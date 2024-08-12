"""
We need to install the Pillow library to manage images. Pillow is the de facto standard library for image
processing in Python. It supports multiple image formats and provides powerful image processing
functions. Pillow is required by Django to handle images with ImageField.

pip install Pillow
____________________________________________

Edit the settings.py file of the project and add the following lines:

MEDIA_URL = 'media/'
MEDIA_ROOT = BASE_DIR / 'media'
____________________________________________

Now, edit the main urls.py file:

from django.conf import settings
from django.conf.urls.static import static

urlpatterns = [
    ...
]

if settings.DEBUG:
    urlpatterns += static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)


Remember that the static() helper function is suitable for development but not for
production use. Django is very inefficient at serving static files. Never serve your static
files with Django in a production environment.

"""