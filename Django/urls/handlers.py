"""
Specify the handlers in your URLconf (setting them anywhere else will have no effect).
Чтобы хендлеры работали debug должен быть выключен в settings.py и прописаны allowed_hosts.

The page_not_found() view is overridden by handler404:
handler404 = "mysite.views.my_custom_page_not_found_view"

The server_error() view is overridden by handler500:
handler500 = "mysite.views.my_custom_error_view"

The permission_denied() view is overridden by handler403:
handler403 = "mysite.views.my_custom_permission_denied_view"

The bad_request() view is overridden by handler400:
handler400 = "mysite.views.my_custom_bad_request_view"
________________________________________________________________________________________________________________________
handler404
A callable, or a string representing the full Python import path to the view
that should be called if none of the URL patterns match.

By default, this is django.views.defaults.page_not_found().
If you implement a custom view, be sure it accepts request and exception arguments and returns an HttpResponseNotFound.

# views.py
from django.http import HttpResponseNotFound
from django.shortcuts import render


def custom_handler404(request, exception):
    return HttpResponseNotFound(render(request, 'custom_404.html', context={}))


# urls.py
from app.views import custom_handler404
...

urlpatterns = [
    ...
]

handler404 = custom_handler404
"""