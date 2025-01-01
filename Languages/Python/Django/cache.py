'''
You should always define your cache strategy wisely, taking into account expensive QuerySets or calculations, data
that won’t change frequently, and data that will be accessed concurrently by many users.
________________________________________________________________________________________________________________________
docker pull memcached
docker run -it --rm --name memcached -p 11211:11211 memcached -m 64
pip install pymemcache

CACHES = {
    'default': {
        'BACKEND': 'django.core.cache.backends.memcached.PyMemcacheCache',
        'LOCATION': '127.0.0.1:11211',
    }
}

You are using the PyMemcacheCache backend. You specify its location using the address:port notation.
If you have multiple Memcached instances, you can use a list for LOCATION.
________________________________________________
docker pull redis
docker run -it --rm --name redis -p 6379:6379 redis
pip install redis

CACHES = {
    'default': {
        'BACKEND': 'django.core.cache.backends.redis.RedisCache',
        'LOCATION': 'redis://127.0.0.1:6379',
    }
}

The project will now use the RedisCache cache backend. The location is defined in the format redis://[host]:[port].
You use 127.0.0.1 to point to the local host and 6379, which is the default port for Redis.

________________________________________________________________________________________________________________________
Django cache settings:

• CACHES: A dictionary containing all available caches for the project.
• CACHE_MIDDLEWARE_ALIAS: The cache alias to use for storage.
• CACHE_MIDDLEWARE_KEY_PREFIX: The prefix to use for cache keys. Set a prefix to avoid key
  collisions if you share the same cache between several sites.
• CACHE_MIDDLEWARE_SECONDS: The default number of seconds to cache pages.

Each cache included in the CACHES dictionary can specify the following data:

• BACKEND: The cache backend to use.
• KEY_FUNCTION: A string containing a dotted path to a callable that takes a prefix, version, and
  key as arguments and returns a final cache key.
• KEY_PREFIX: A string prefix for all cache keys, to avoid collisions.
• LOCATION: The location of the cache. Depending on the cache backend, this might be a directory,
  a host and port, or a name for the in-memory backend.
• OPTIONS: Any additional parameters to be passed to the cache backend.
• TIMEOUT: The default timeout, in seconds, for storing the cache keys. It is 300 seconds by default,
  which is 5 minutes. If set to None, cache keys will not expire.
• VERSION: The default version number for the cache keys. Useful for cache versioning.




________________________________________________________________________________________________________________________
Cache levels
Django provides the following levels of caching, listed here by ascending order of granularity:

• Low-level cache API: Provides the highest granularity. Allows you to cache specific queries
  or calculations.
• Template cache: Allows you to cache template fragments.
• Per-view cache: Provides caching for individual views.
• Per-site cache: The highest-level cache. It caches your entire site.
________________________________________________
Using the low-level cache API:

from django.core.cache import cache

subjects = Subject.objects.all()
cache.set('my_subjects', subjects)
cache.get('my_subjects')
________________________________________________
Caching template fragments:
{% load cache %}
{% cache 300 fragment_name %}
    ...
{% endcache %}
________________________________________________
Caching views:
from django.views.decorators.cache import cache_page

urlpatterns = [
    ...
    path('course/<pk>/', cache_page(60 * 15)(views.StudentCourseDetailView.as_view()), name='student_course_detail'),
    path('course/<pk>/<module_id>/', cache_page(60 * 15)(views.StudentCourseDetailView.as_view()), name='student_course_detail_module'),
]
The per-view cache uses the URL to build the cache key. Multiple URLs pointing to the
same view will be cached separately.
________________________________________________
Using the per-site cache:

MIDDLEWARE = [
    ...
    'django.middleware.cache.UpdateCacheMiddleware',
    'django.middleware.common.CommonMiddleware',
    'django.middleware.cache.FetchFromCacheMiddleware',
    ...
]

Remember that middleware is executed in the given order during the request phase, and in reverse order
during the response phase. UpdateCacheMiddleware is placed before CommonMiddleware because it
runs during response time, when middleware is executed in reverse order. FetchFromCacheMiddleware
is placed after CommonMiddleware intentionally because it needs to access request data set by the latter.

CACHE_MIDDLEWARE_ALIAS = 'default'
CACHE_MIDDLEWARE_SECONDS = 60 * 15 # 15 minutes
CACHE_MIDDLEWARE_KEY_PREFIX = 'educa'












'''