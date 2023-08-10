# laravel-demo


#There are 5 APIs in the deom project:
  1. The get request is successful
    http(s)://xxxx.com/demo/success_get
  2. The post request is successful
    http(s)://xxxx.com/demo/success_post
  3. The age parameter is required and must be an integer, otherwise it will return a forced judgment get request that prompts an error
    http(s)://xxxx.com/demo/expected_get
  4. get request error
    http(s)://xxxx.com/demo/error_get
  5. The s parameter is required, and must be '(', '[', '{' characters to force and correctly close the get request
    http(s)://xxxx.com/demo/match_get
