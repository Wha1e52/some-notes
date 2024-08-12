"""
Project-Level Permissions:

REST framework includes a permission system to restrict access to views. Some of the built-in permissions
of REST framework are:

• AllowAny: Unrestricted access, regardless of whether a user is authenticated or not.
• IsAuthenticated: Allows access to authenticated users only.
• IsAdminUser: - only admins/superusers have access
• IsAuthenticatedOrReadOnly: Complete access to authenticated users. Anonymous users are
  only allowed to execute read methods such as GET, HEAD, or OPTIONS.
• DjangoModelPermissions: Permissions tied to django.contrib.auth. The view requires a
  queryset attribute. Only authenticated users with model permissions assigned are granted permission.
• DjangoModelPermissionsOrAnonReadOnly: Similar to DjangoModelPermissions, but also allows unauthenticated users
  to have read-only access to the API.
• DjangoObjectPermissions: Django permissions on a per-object basis.

# django_project/settings.py
REST_FRAMEWORK = {
    "DEFAULT_PERMISSION_CLASSES": [
        "rest_framework.permissions.AllowAny",
    ],
}
________________________________________________________________________________________________________________________
View-Level Permissions:

from rest_framework import generics, permissions

class PostDetail(generics.RetrieveUpdateDestroyAPIView):
    permission_classes = [permissions.IsAdminUser] #new
    queryset = Post.objects.all()
    serializer_class = PostSerializer
________________________________________________________________________________________________________________________
Custom Permissions:

from rest_framework import permissions


class IsAuthorOrReadOnly(permissions.BasePermission):
    def has_permission(self, request, view):
        # Authenticated users only can see list view
        if request.user.is_authenticated:
            return True
        return False

    def has_object_permission(self, request, view, obj):
        # Read permissions are allowed to any request so we'll always
        # allow GET, HEAD, or OPTIONS requests
        if request.method in permissions.SAFE_METHODS:
            return True
        # Write permissions are only allowed to the author of a post
        return obj.author == request.user


"""
