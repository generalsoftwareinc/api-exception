<?php

namespace GsiTools;

class ApiException extends Exception {

    private static $errors_dictionary;
    private $http_status;
    private $headers;

    /**
     * @param array $errors_dictionary   Custom application errors dictionary. Example:
     *                                  [
     *                                      401001 => 'Invalid token: %s',
     *                                      400100 => "The property '%s' is required.",
     *                                      400108 => "The parameter '%s' is invalid.",
     *                                      409001 => 'The %s already exists.',
     *                                  ]
     *                                  Note that message can hold placeholders to be replaced by
     *                                  $message_args in constructor.
     */
    public static function set_errors_dictionary(Array &$errors_dictionary)
    {
        self::$errors_dictionary = $errors_dictionary;
    }

    /**
     * 
     * @param int $http_status       HTTP status code. Default value: 500 (Internal Server Error).
     * @param int $error_code        Custom application error code
     * @param string $message       Exception message. If no value ('' or null) but $errorCode, the message will be
     *                              searched in self::$error_dictionary.
     * @param mixed $message_args   Array with arguments to replace message placeholder (%s, %d) using vsprintf().
     *                              If there is only one argument, it could be passed as simple string
     * @param array $headers        Associative array with ('Header' => 'value') structure. It should be managed by
     *                              the app to include them in response.
     */
    public function __construct($http_status = 500, $error_code = null, $message = null, $message_args = null, $headers = null)
    {
        if (empty($message))
        {
            if (!empty(self::$errors_dictionary[$error_code]))
            {
                $message = self::$errors_dictionary[$error_code];
            }
            elseif (!empty(self::$errors_dictionary[$http_status]))
            {
                $message = self::$errors_dictionary[$http_status];
            }
        }

        if (!empty($message))
        {
            if (is_string($message_args))
            {
                $message_args = [$message_args];
            }

            if (is_array($message_args) && $message_args)
            {
                $message = vsprintf($message, $message_args);
            }
        }

        parent::__construct($message, $error_code ?  $error_code : $http_status);

        if (is_array($headers))
        {
            $this->headers = $headers;
        }

        $this->http_status = $http_status;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getHttpStatus()
    {
        return $this->http_status;
    }
}
