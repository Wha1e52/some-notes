"""
Django REST Framework ships with four different built-in authentication options: basic, session, token, and default.
And there are many more third-party packages that offer additional features like JSON Web Tokens (JWTs).

REST framework provides the following authentication backends:

• BasicAuthentication: This is HTTP basic authentication. The user and password are sent by
  the client in the Authorization HTTP header encoded with Base64.
• TokenAuthentication: This is token-based authentication. A Token model is used to store
  user tokens. Users include the token in the Authorization HTTP header for authentication.
• SessionAuthentication: This uses Django’s session backend for authentication. This backend
  is useful for performing authenticated AJAX requests to the API from your website’s frontend.
• RemoteUserAuthentication: This allows you to delegate authentication to your web server,
  which sets a REMOTE_USER environment variable.
__________________________________________________________________________
Basic Authentication:

The complete request/response flow looks like this:
1. Client makes an HTTP request
2. Server responds with an HTTP response containing a 401 (Unauthorized) status code and
   WWW-Authenticate HTTP header with details on how to authorize
3. Client sends credentials back via the Authorization HTTP header
4. Server checks credentials and responds with either 200 OK or 403 Forbidden status code
Once approved, the client sends all future requests with the Authorization HTTP header
credentials. We can also visualize this exchange as follows:

Client                                      Server
------                                      ------

--------------------------------------->
GET / HTTP/1.1
                                            <-------------------------------------
                                            HTTP/1.1 401 Unauthorized
                                            WWW-Authenticate: Basic
--------------------------------------->
GET / HTTP/1.1
Authorization: Basic d3N2OnBhc3N3b3JkMTIz
                                            <-------------------------------------
                                            HTTP/1.1 200 OK


Basic authentication should only be used via HTTPS, the secure version of HTTP.
__________________________________________________________________________
Session Authentication:

The basic flow:
1. A user enters their log in credentials (typically username/password)
2. The server verifies the credentials are correct and generates a session object that is then
   stored in the database
3. The server sends the client a session ID—not the session object itself—which is stored as a
   cookie on the browser
4. On all future requests the session ID is included as an HTTP header and, if verified by the
   database, the request proceeds
5. Once a user logs out of an application, the session ID is destroyed by both the client and
   server
6. If the user later logs in again, a new session ID is generated and stored as a cookie on the
   client

It is generally not advised to use a session-based authentication scheme for any API
that will have multiple front-ends
__________________________________________________________________________
Token Authentication:

Token-based authentication is stateless: once a client sends the initial user credentials to the
server, a unique token is generated and then stored by the client as either a cookie or in local
storage. This token is then passed in the header of each incoming HTTP request and the server
uses it to verify that a user is authenticated. The server itself does not keep a record of the user,
just whether a token is valid or not.


Client                                      Server
------                                      ------

--------------------------------------->
GET / HTTP/1.1
                                            <-------------------------------------
                                            HTTP/1.1 401 Unauthorized
                                            WWW-Authenticate: Token
--------------------------------------->
GET / HTTP/1.1
Authorization: Token 401f7ac837da42b97f613d789819ff93537bee6a
                                            <-------------------------------------
                                            HTTP/1.1 200 OK

JSON Web Tokens (JWTs) are a newer form of token containing cryptographically signed JSON
data. JWTs were originally designed for use in OAuth, an open standard way for websites
to share access to user information without actually sharing user passwords. JWTs can be
generated on the server with a third-party package like djangorestframework-simplejwt or
via a third-party service like Auth0.

# django_project/settings.py
INSTALLED_APPS = [
    ...
    "rest_framework",
    "corsheaders",
    "rest_framework.authtoken", # new
    ...
]

REST_FRAMEWORK = {
    ...
    "DEFAULT_AUTHENTICATION_CLASSES": [
        "rest_framework.authentication.SessionAuthentication",
        "rest_framework.authentication.TokenAuthentication",
    ],
}
__________________________________________________________________________
Default Authentication

# django_project/settings.py
REST_FRAMEWORK = {
    ...
    "DEFAULT_AUTHENTICATION_CLASSES": [
        "rest_framework.authentication.SessionAuthentication",
        "rest_framework.authentication.BasicAuthentication",
    ],
}
__________________________________________________________________________
Endpoints

We also need to create endpoints so users can log in and log out. We could create a dedicated
users app for this purpose and then add our own urls, views, and serializers. However user
authentication is an area where we really do not want to make a mistake. And since almost all APIs
require this functionality, it makes sense that there are several excellent and tested third-party
packages we can use instead.
Notably we will use dj-rest-auth in combination with django-allauth to simplify things. Don’t
feel bad about using third-party packages. They exist for a reason and even the best Django
professionals rely on them all the time. There is no point in reinventing the wheel if you don’t
have to!


















"""