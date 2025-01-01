"""
Django comes with two base classes to build forms:
• Form: Allows you to build standard forms by defining fields and validations.
• ModelForm: Allows you to build forms tied to model instances. It provides all the functionalities
of the base Form class, but form fields can be explicitly declared, or automatically generated,
from model fields. The form can be used to create or edit model instances.

from django import forms
from .models import Comment


class EmailPostForm(forms.Form):
    name = forms.CharField(max_length=25, label='Имя')
    email = forms.EmailField()
    to = forms.EmailField()
    comments = forms.CharField(required=False, widget=forms.Textarea(attrs={'rows': 5, 'cols': 50, class: 'myClass'}))


class CommentForm(forms.ModelForm):
    class Meta:
        model = Comment
        fields = ['name', 'email', 'body']
        labels = {
            'name': 'Имя',
            'email': 'Email',
            'body': 'Текст',
        }
________________________________________________________________________________________________________________________

class ImageCreateForm(forms.ModelForm):
    class Meta:
        model = Image
        fields = ['title', 'url', 'description']
        widgets = {
            'url': forms.HiddenInput,
        }

    def clean_url(self):
        url = self.cleaned_data['url']
        valid_extensions = ['jpg', 'jpeg', 'png']
        extension = url.rsplit('.', 1)[1].lower()
        if extension not in valid_extensions:
            raise forms.ValidationError('The given URL does not match valid image extensions.')
        return url

clean_<fieldname>() convention to implement field validation. This method is executed
for each field, if present, when we call is_valid() on a form instance. In the clean method, you can
alter the field’s value or raise any validation errors for the field.

"""