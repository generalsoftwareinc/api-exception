# api-exception

ApiException should be used by applications to throw a custom exception based on a dictionary of application errors.
It holds exception data that application should manage to build the response. 

You can generate ApiException anywhere:
  
 
# How to use it
    
    //At some point in the begining
    \ApiException::set_error_dictionary($app_errors_dictionary);
    
    try
    {
      
        //Take a look to constructor parameters to see more details
        throw new ApiException(409, 409001, null, 'user', ['Location' => 'https://site.com/api/v1/users/435']);
    }
    catch (ApiException $exc)
    {
        //build and send: a response using the ApiException data (HTTP status, message, error code, headers, etc.)
    }
    catch (Exception $exc)
    {
        //build and send: 500 Internal Server Error
    }

The `$app_errors_dictionary` could be something like this:

    [
        401001 => 'Invalid token: %s',
        400100 => "The property '%s' is required.",
        400108 => "The parameter '%s' is invalid.",
        409001 => 'The %s already exists.',
    ]
    
Note that message can hold placeholders to be replaced by `$messageArgs` (4th parameter) in constructor.
