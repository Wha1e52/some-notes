"""
The following path converters are available by default:

str - Matches any non-empty string, excluding the path separator, '/'.
      This is the default if a converter isn’t included in the expression.

int - Matches zero or any positive integer. Returns an int.
      slug - Matches any slug string consisting of ASCII letters or numbers, plus the hyphen and underscore characters.
      For example, building-your-1st-django-site.

uuid - Matches a formatted UUID. To prevent multiple URLs from mapping to the same page, dashes must be
    included and letters must be lowercase. For example, 075194d3-6885-417e-a8a8-6c931e272f00. Returns a UUID instance.

path - Matches any non-empty string, including the path separator, '/'.
       This allows you to match against a complete URL path rather than a segment of a URL path as with str.
________________________________________________________________________________________________________________________
custom path converters

A converter is a class that includes the following:
A regex class attribute, as a string.

A to_python(self, value) method, which handles converting the matched string
into the type that should be passed to the view function. It should raise ValueError if it can’t convert the given
value.

A ValueError is interpreted as no match and as a consequence a 404 response is sent to the user unless another
URL pattern matches. A to_url(self, value) method, which handles converting the Python type into a string to be used
in the URL. It should raise ValueError if it can’t convert the given value. A ValueError is interpreted as no match
and as a consequence reverse() will raise NoReverseMatch unless another URL pattern matches.

class FourDigitYearConverter:
    regex = "[0-9]{4}"

    def to_python(self, value):
        return int(value)

    def to_url(self, value):
        return "%04d" % value
________________________________________________________________________________________________________________________
Register custom converter classes in your URLconf using register_converter():

from django.urls import path, register_converter

from . import converters, views

register_converter(converters.FourDigitYearConverter, "yyyy")

urlpatterns = [
    path("articles/2003/", views.special_case_2003),
    path("articles/<yyyy:year>/", views.year_archive),
    ...,
]
"""