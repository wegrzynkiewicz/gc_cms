<?php

class WarningException              extends ErrorException {}
class ParseException                extends ErrorException {}
class NoticeException               extends ErrorException {}
class CoreErrorException            extends ErrorException {}
class CoreWarningException          extends ErrorException {}
class CompileErrorException         extends ErrorException {}
class CompileWarningException       extends ErrorException {}
class UserErrorException            extends ErrorException {}
class UserWarningException          extends ErrorException {}
class UserNoticeException           extends ErrorException {}
class StrictException               extends ErrorException {}
class RecoverableErrorException     extends ErrorException {}
class DeprecatedException           extends ErrorException {}
class UserDeprecatedException       extends ErrorException {}

/**
 * Throw exceptions based on E_* error types
 */
set_error_handler(function ($err_severity, $err_msg, $err_file, $err_line, array $err_context) {

    $errorReporting = error_reporting();

    GC\Container::get('logger')->error($err_msg, [$err_file, $err_line]);

    if ($errorReporting == 0) {
        return false;
    }

    switch ($err_severity & $errorReporting) {
        case E_ERROR:               throw new ErrorException($err_msg, 0, $err_severity, $err_file, $err_line);
        case E_WARNING:             throw new WarningException($err_msg, 0, $err_severity, $err_file, $err_line);
        case E_PARSE:               throw new ParseException($err_msg, 0, $err_severity, $err_file, $err_line);
        case E_NOTICE:              throw new NoticeException($err_msg, 0, $err_severity, $err_file, $err_line);
        case E_CORE_ERROR:          throw new CoreErrorException($err_msg, 0, $err_severity, $err_file, $err_line);
        case E_CORE_WARNING:        throw new CoreWarningException($err_msg, 0, $err_severity, $err_file, $err_line);
        case E_COMPILE_ERROR:       throw new CompileErrorException($err_msg, 0, $err_severity, $err_file, $err_line);
        case E_COMPILE_WARNING:     throw new CoreWarningException($err_msg, 0, $err_severity, $err_file, $err_line);
        case E_USER_ERROR:          throw new UserErrorException($err_msg, 0, $err_severity, $err_file, $err_line);
        case E_USER_WARNING:        throw new UserWarningException($err_msg, 0, $err_severity, $err_file, $err_line);
        case E_USER_NOTICE:         throw new UserNoticeException($err_msg, 0, $err_severity, $err_file, $err_line);
        case E_STRICT:              throw new StrictException($err_msg, 0, $err_severity, $err_file, $err_line);
        case E_RECOVERABLE_ERROR:   throw new RecoverableErrorException($err_msg, 0, $err_severity, $err_file, $err_line);
        case E_DEPRECATED:          throw new DeprecatedException($err_msg, 0, $err_severity, $err_file, $err_line);
        case E_USER_DEPRECATED:     throw new UserDeprecatedException($err_msg, 0, $err_severity, $err_file, $err_line);
    }

    return false;
});

set_exception_handler(function (Exception $exception) {

    $logException = function(Exception $exception) use (&$logException) {

        $previous = $exception->getPrevious();

        if ($previous) {
            $logException($previous);
        }

        GC\Container::get('logger')->exception(
            sprintf("%s: %s [%s]\n%s",
                get_class($exception),
                $exception->getMessage(),
                $exception->getCode(),
                $exception->getTraceAsString()
            ),
            []
        );
    };

    $logException($exception);

    throw $exception;
});
