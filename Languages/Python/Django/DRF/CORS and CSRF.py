"""
CORS

Cross-Origin Resource Sharing (CORS) refers to the fact that whenever a client interacts with
an API hosted on a different domain (mysite.com vs yoursite.com) or port (localhost:3000 vs localhost:8000)
there are potential security issues.
Specifically, CORS requires the web server to include specific HTTP headers that allow for the
client to determine if and when cross-domain requests should be allowed. Because we are using
a SPA architecture the front-end will be on a different local port during development and a
completely different domain once deployed!
The easiest way to handle this issue–-and the one recommended by Django REST Framework–
-is to use middleware that will automatically include the appropriate HTTP headers based on our
settings. The third-party package django-cors-headers is the default choice within the Django
community.

python -m pip install django-cors-headers

• add corsheaders to the INSTALLED_APPS
• add CorsMiddleware above CommonMiddleWare in MIDDLEWARE
• create a CORS_ALLOWED_ORIGINS config at the bottom of the file

# django_project/settings.py
INSTALLED_APPS = [
    "django.contrib.admin",
    "django.contrib.auth",
    "django.contrib.contenttypes",
    "django.contrib.sessions",
    "django.contrib.messages",
    "django.contrib.staticfiles",
    # 3rd party
    "rest_framework",
    "corsheaders", # new
    # Local
    "todos.apps.TodosConfig",
]

MIDDLEWARE = [
    "django.middleware.security.SecurityMiddleware",
    "django.contrib.sessions.middleware.SessionMiddleware",
    "corsheaders.middleware.CorsMiddleware", # new
    "django.middleware.common.CommonMiddleware",
    "django.middleware.csrf.CsrfViewMiddleware",
    "django.contrib.auth.middleware.AuthenticationMiddleware",
    "django.contrib.messages.middleware.MessageMiddleware",
    "django.middleware.clickjacking.XFrameOptionsMiddleware",
]

CORS_ALLOWED_ORIGINS = (
    "http://localhost:3000",
    "http://localhost:8000",
)
__________________________________________________________________________
CSRF

Just as CORS is an issue when dealing with a SPA architecture, so too are forms. Django comes
with robust CSRF protection that should be added to forms in any Django template, but with
a dedicated React front-end setup this protection isn’t inherently available. Fortunately, we can
allow specific cross-domain requests from our frontend by setting CSRF_TRUSTED_ORIGINS.

# django_project/settings.py
CSRF_TRUSTED_ORIGINS = ["http://localhost:3000"]

And that’s it! Our back-end is now capable of communicating with any front-end
that uses port 3000. If our front-end of choice dictates a different port that can easily be updated
in our code.
"""