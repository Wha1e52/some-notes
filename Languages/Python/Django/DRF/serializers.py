"""
A serializer translates complex data like querysets and model instances into a format that is
easy to consume over the internet, typically JSON.

Output data has to be serialized in a specific format, and input data will be deserialized for processing.
The framework provides the following classes to build serializers for single objects:

• Serializer: Provides serialization for normal Python class instances
• ModelSerializer: Provides serialization for model instances
• HyperlinkedModelSerializer: The same as ModelSerializer, but it represents object relationships
  with links rather than primary keys
________________________________________________________________________________________________________________________

class PostSerializer(serializers.ModelSerializer):
    class Meta:
        model = Post
        fields = ("id","author","title","body","created_at",)


class UserSerializer(serializers.ModelSerializer):
    class Meta:
        model = get_user_model()
        fields = ["id", "username"]
__________________________________________________________________________________________________
Nested serializers:

class ModuleSerializer(serializers.ModelSerializer):
    class Meta:
        model = Module
        fields = ['order', 'title', 'description']


class CourseSerializer(serializers.ModelSerializer):
    modules = ModuleSerializer(many=True, read_only=True)

    class Meta:
        model = Course
        fields = ['id', 'subject', 'title', 'slug', 'overview', 'created', 'owner', 'modules']

You set many=True to indicate that you are serializing multiple objects.
The read_only parameter indicates that this field is read-only
and should not be included in any input to create or update objects.

__________________________________________________________________________________________________
from django.contrib.auth.models import User

class UserSerializer(serializers.ModelSerializer):
    snippets = serializers.PrimaryKeyRelatedField(many=True, queryset=Snippet.objects.all())

    class Meta:
        model = User
        fields = ['id', 'username', 'snippets']

Because 'snippets' is a reverse relationship on the User model, it will not be included by default when using
the ModelSerializer class, so we needed to add an explicit field for it.

__________________________________________________________________________________________________
Working with Serializers

Before we go any further we'll familiarize ourselves with using our new Serializer class.
Let's drop into the Django shell.

python manage.py shell
Okay, once we've got a few imports out of the way, let's create a couple of code snippets to work with.

from snippets.models import Snippet
from snippets.serializers import SnippetSerializer
from rest_framework.renderers import JSONRenderer
from rest_framework.parsers import JSONParser

snippet = Snippet(code='foo = "bar"\n')
snippet.save()

snippet = Snippet(code='print("hello, world")\n')
snippet.save()
We've now got a few snippet instances to play with. Let's take a look at serializing one of those instances.

serializer = SnippetSerializer(snippet)
serializer.data
# {'id': 2, 'title': '', 'code': 'print("hello, world")\n', 'linenos': False, 'language': 'python', 'style': 'friendly'}
At this point we've translated the model instance into Python native datatypes.
To finalize the serialization process we render the data into json.

content = JSONRenderer().render(serializer.data)
content
# b'{"id": 2, "title": "", "code": "print(\\"hello, world\\")\\n",
"linenos": false, "language": "python", "style": "friendly"}'
Deserialization is similar. First we parse a stream into Python native datatypes...

import io

stream = io.BytesIO(content)
data = JSONParser().parse(stream)
...then we restore those native datatypes into a fully populated object instance.

serializer = SnippetSerializer(data=data)
serializer.is_valid()
# True
serializer.validated_data
# OrderedDict([('title', ''), ('code', 'print("hello, world")\n'),
('linenos', False), ('language', 'python'), ('style', 'friendly')])
serializer.save()
# <Snippet: Snippet object>
Notice how similar the API is to working with forms.
The similarity should become even more apparent when we start writing views that use our serializer.

We can also serialize querysets instead of model instances.
To do so we simply add a many=True flag to the serializer arguments.

serializer = SnippetSerializer(Snippet.objects.all(), many=True)
serializer.data
# [OrderedDict([('id', 1), ('title', ''), ('code', 'foo = "bar"\n'),
('linenos', False), ('language', 'python'), ('style', 'friendly')]),
OrderedDict([('id', 2), ('title', ''), ('code', 'print("hello, world")\n'), ('linenos', False),
('language', 'python'), ('style', 'friendly')]), OrderedDict([('id', 3), ('title', ''),
('code', 'print("hello, world")'), ('linenos', False), ('language', 'python'), ('style', 'friendly')])]
__________________________________________________________________________________________________



































"""