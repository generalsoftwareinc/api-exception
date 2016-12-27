# api-exception

ApiException should be used by applications to throw a custom exception based on a dictionary of application errors.
It holds exception data that application should manage to build the response.   
 
# How to use it
    
    //At some point in the begining
    \GsiTools\ApiException::setErrorDictionary($app_errors_dictionary);
    
    try
    {
      
        //Take a look to constructor parameters to see more details
        throw new \GsiTools\ApiException(409, 409001, null, 'user', ['Location' => 'https://site.com/api/v1/users/435']);
    }
    catch (\GsiTools\ApiException $api_exc)
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

# How to install

Add a new repository in your composer.json file as follow:

    {
        "type": "vcs",
        "url": "https://github.com/generalsoftwareinc/api-exception"
    }

Also add this line into `require` section in composer.json file:

    "generalsoftwareinc/api-exception": "0.1.*"
    
Finally execute:

    composer update generalsoftwareinc/api-exception

