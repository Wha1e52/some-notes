"""
Every RESTful API:

• is stateless, like HTTP
• supports common HTTP verbs (GET, POST, PUT, DELETE, etc.)
• returns data in either the JSON or XML format

Any RESTful API must, at a minimum, have these three principles. The standard is important
because it provides a consistent way to both design and consume web APIs.
__________________________________________________________________________

pip install djangorestframework
__________________________________________________________________________
Edit the settings.py:

INSTALLED_APPS = [
    ...
    'rest_framework',
]

REST_FRAMEWORK = {
    'DEFAULT_PERMISSION_CLASSES': [
    'rest_framework.permissions.DjangoModelPermissionsOrAnonReadOnly'
    ]
}
__________________________________________________________________________
serializers.py file:

from rest_framework import serializers
from courses.models import Subject

class SubjectSerializer(serializers.ModelSerializer):
    class Meta:
        model = Subject
        fields = ['id', 'title', 'slug']

All model fields will be included if you don’t set a fields attribute.
__________________________________________________________________________
url.py:

from django.urls import path
from . import views

app_name = 'courses'

urlpatterns = [
    path('subjects/', views.SubjectListView.as_view(), name='subject_list'),
    path('subjects/<pk>/', views.SubjectDetailView.as_view(), name='subject_detail'),
]

Edit the main urls.py file of the project and include the API patterns, as follows:
urlpatterns = [
    ...
    path('api/', include('courses.api.urls', namespace='api')),
]

__________________________________________________________________________
views.py:

from rest_framework import generics
from courses.models import Subject
from courses.api.serializers import SubjectSerializer

class SubjectListView(generics.ListAPIView):
    queryset = Subject.objects.all()
    serializer_class = SubjectSerializer

class SubjectDetailView(generics.RetrieveAPIView):
    queryset = Subject.objects.all()
    serializer_class = SubjectSerializer

"""