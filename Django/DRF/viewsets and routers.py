"""
ViewSets

A viewset is a way to combine the logic for multiple related views into a single class. In other
words, one viewset can replace multiple views.

ViewSets include actions for the following standard operations:

• Create operation: create()
• Retrieve operation: list() and retrieve()
• Update operation: update() and partial_update()
• Delete operation: destroy()
__________________________________________________________________________

class PostViewSet(viewsets.ModelViewSet):
    permission_classes = [IsAuthorOrReadOnly]
    queryset = Post.objects.all()
    serializer_class = PostSerializer


class UserViewSet(viewsets.ModelViewSet):
    permission_classes = [IsAdminUser]
    queryset = get_user_model().objects.all()
    serializer_class = UserSerializer

__________________________________________________________________________
Routers

Routers work directly with viewsets to automatically generate URL patterns for us.

Django REST Framework has two default routers: SimpleRouter and DefaultRouter.
But it’s also possible to create custom routers for more advanced functionality


# posts/urls.py
from django.urls import path
from rest_framework.routers import SimpleRouter
from .views import UserViewSet, PostViewSet

router = SimpleRouter()
router.register("users", UserViewSet, basename="users")
router.register("", PostViewSet, basename="posts")
urlpatterns = router.urls


# xyz/urls.py
from django.urls import path, include
from rest_framework import routers
from . import views

router = routers.DefaultRouter()
router.register('courses', views.CourseViewSet)

urlpatterns = [
    path('', include(router.urls)),
    path('subjects/', views.SubjectListView.as_view(), name='subject_list'),
    path('subjects/<pk>/', views.SubjectDetailView.as_view(), name='subject_detail'),
    # path('courses/<pk>/enroll/', views.CourseEnrollView.as_view(), name='course_enroll'),
]




"""