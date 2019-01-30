<?php

namespace App\Domains\Account;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth as AuthFacade;
use App\Domains\Account\Resources\UserResource;

class Auth
{
    use ThrottlesLogins;

    /**
     * The login username.
     *
     * @var string
     */
    protected $username = 'email';

    /**
     * The maximum number of attempts to allow.
     *
     * @var int
     */
    protected $maxAttempts = 5;

    /**
     * The number of minutes to throttle for.
     *
     * @var int
     */
    protected $decayMinutes = 1;

    /**
     * Is the login locked out?
     *
     * @var bool
     */
    protected $isLocked = false;

    /**
     * Log the user in of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function login(Request $request)
    {
        // Determine if the user has too many failed login attempts.
        if ($this->hasTooManyLoginAttempts($request)) {
            // Fire an event when a lockout occurs.
            $this->fireLockoutEvent($request);

            // Login is locked out.
            $this->isLocked = true;

            return false;
        }

        // We tried to log in.
        $token = $this->attemptLogin($request);

        if (!$token) {
            // Increments login attempts.
            $this->incrementLoginAttempts($request);

            return false;
        }

        // Clear the login locks for the given user credentials
        $this->clearLoginAttempts($request);

        // Get the current logged user.
        $user = $this->guard()->user();

        return $this->authenticated($token, $user);
    }

    /**
     * Refresh a token.
     *
     * @return array
     */
    public function refreshToken(): array
    {
        return $this->formatToken(AuthFacade::refresh());
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function attemptLogin(Request $request): ?string
    {
        return $this->guard()->attempt(
            $this->credentials($request)
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request): array
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * The user has been authenticated.
     *
     * @param  string                    $token
     * @param  mixed                     $user
     * @return array
     */
    protected function authenticated(string $token, $user): array
    {
        return [
            'user' => new UserResource($user),
            'jwt' => $this->formatToken($token)
        ];
    }

    /**
     * Format hot the token will be returned.
     *
     * @param  string  $token
     * @return array
     */
    protected function formatToken(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => AuthFacade::factory()->getTTL() * 60
        ];
    }

    /**
     * Checks if the login is locked out. If so, it returns for how many minutes
     * it will be locked.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return false|int
     */
    public function isLocked(Request $request)
    {
        if (!$this->isLocked) {
            return false;
        }

        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        return $seconds;
    }

    /**
     * Set the login username.
     *
     * @param  string  $username
     * @return self
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set the maximum number of attempts to allow.
     *
     * @param  int  $maxAttempts
     * @return self
     */
    public function setMaxAttempts(int $maxAttempts): self
    {
        $this->maxAttempts = $maxAttempts;

        return $this;
    }

    /**
     * Set the number of minutes to throttle for.
     *
     * @param  int  $decayMinutes
     * @return self
     */
    public function setDecayMinutes(int $decayMinutes): self
    {
        $this->decayMinutes = $decayMinutes;

        return $this;
    }

    /**
     * Get the login username.
     *
     * @return string
     */
    public function username(): string
    {
        return $this->username;
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return AuthFacade::guard('api');
    }
}
