"""
Schema

A schema is a machine-readable document that outlines all available API endpoints, URLs, and
the HTTP verbs (GET, POST, PUT, DELETE, etc.).

drf-spectacular is the recommended third-party package for generating an OpenAPI 3 schema for Django REST Framework.
python -m pip install drf-spectacular


INSTALLED_APPS = [
    ...
"drf_spectacular",
]

REST_FRAMEWORK = {
    ...
    "DEFAULT_SCHEMA_CLASS": "drf_spectacular.openapi.AutoSchema",
}

SPECTACULAR_SETTINGS = {
    "TITLE": "Blog API Project",
    "DESCRIPTION": "A sample blog to learn about DRF",
    "VERSION": "1.0.0",
    # OTHER SETTINGS
}

python manage.py spectacular --file schema.yml
__________________________________________________________________________
Documentation

# django_project/urls.py
from django.contrib import admin
from django.urls import path, include
from drf_spectacular.views import SpectacularAPIView, SpectacularRedocView, SpectacularSwaggerView

urlpatterns = [
    ...
    path("api/schema/", SpectacularAPIView.as_view(), name="schema"),
    path("api/schema/redoc/", SpectacularRedocView.as_view(url_name="schema"), name="redoc",),
    path("api/schema/swagger-ui/", SpectacularSwaggerView.as_view(url_name="schema"), name="swagger-ui"),
]
"""