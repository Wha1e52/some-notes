'''
# лучше посмотреть в документации

pip install django-debug-toolbar

INSTALLED_APPS = [
     ...
    'debug_toolbar',
]

Remember that DebugToolbarMiddleware has to be placed before any other middleware, except for
middleware that encodes the response’s content, such as GZipMiddleware, which, if present, should
come first.

MIDDLEWARE = [
    'debug_toolbar.middleware.DebugToolbarMiddleware',
     ...
]

INTERNAL_IPS = [
    '127.0.0.1',
]

Edit the main urls.py file of the project:

urlpatterns = [
    ...
    path('__debug__/', include('debug_toolbar.urls')),
]

'''