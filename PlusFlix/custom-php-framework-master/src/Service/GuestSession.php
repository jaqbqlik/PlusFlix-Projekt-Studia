<?php

namespace App\Service;

use App\Model\Session;

/**
 *
 * działanie
 * przy pierwszym wejściu na stronę generowany jest unikalny guest_id
 * guest_id jest zapisywany w ciasteczku przeglądarki (ważne 1 rok)
 * przy każdym kolejnym wejściu system rozpoznaje gościa po tym ciasteczku
 * dzięki temu możemy śledzić akcje użytkownika
 * no i jeszcze odświerza sesje przy każdym wejściu :)
 *
 */
class GuestSession
{
    private const COOKIE_NAME = 'plusflix_guest_id';
    private const COOKIE_LIFETIME = 60 * 60 * 24 * 365;

    public static function initGuestSession(): string
    {
        if (isset($_COOKIE[self::COOKIE_NAME])) {
            $guestId = $_COOKIE[self::COOKIE_NAME];

            $session = Session::findByGuestId($guestId);
            if ($session) {
                self::refreshSession($session); //tutaj odświeżamy :)
                self::setCookie($guestId);
                return $guestId;
            }
        }

        $guestId = Session::generateGuestId();

        $session = new Session();
        $session->setGuestId($guestId);
        $session->setExpiresAt(date('Y-m-d H:i:s', time() + self::COOKIE_LIFETIME));
        $session->save();

        self::setCookie($guestId);

        return $guestId;
    }
    public static function getGuestId(): ?string
    {
        if (isset($_COOKIE[self::COOKIE_NAME])) {
            return $_COOKIE[self::COOKIE_NAME];
        }
        return null;
    }

    private static function setCookie(string $guestId): void
    {
        setcookie(
            self::COOKIE_NAME,
            $guestId,
            [
                'expires' => time() + self::COOKIE_LIFETIME,
                'path' => '/',
                'secure' => false,
                'httponly' => true,
                'samesite' => 'Lax'
            ]
        );
    }
    private static function refreshSession(Session $session): void
    {
        $newExpiresAt = date('Y-m-d H:i:s', time() + self::COOKIE_LIFETIME);
        $session->setExpiresAt($newExpiresAt);
        $session->save();
    }
}