<?php

/*

// команда для создания
php artisan make:request StorePostRequest



public function authorize(): bool
{
    $comment = Comment::find($this->route('comment'));

    return $comment && $this->user()->can('update', $comment);
}


public function rules(): array
{
    return [
        'title' => 'required|unique:posts|max:255',
        'body' => 'required',
    ];
}

public function messages(): array
{
    return [
        'title.required' => 'A title is required',
        'body.required' => 'A message is required',
    ];
}



// some controller
public function store(StorePostRequest $request): RedirectResponse
{
    // The incoming request is valid...

    // Retrieve the validated input data...
    $validated = $request->validated();

    // Retrieve a portion of the validated input data...
    $validated = $request->safe()->only(['name', 'email']);
    $validated = $request->safe()->except(['name', 'email']);

    // Store the blog post...

    return redirect('/posts');
}
------------------------------------------------------------------------------------------------------------------------

// some controller
request()->validate([
    'title' => ['required', 'max:255'],
    'body' => ['required'],
    'password' => ['confirmed'], // для confirmed в форме должно быть второе поле с 1name_confirmation для сравнения
])
в случае ошибки валидации происходит автоматически редирект на предыдущую страницу

в шаблоне
@if ($errors->any())
    <ul>
        @foreach ($errors as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
либо
@error('title')
    <div class="alert alert-danger">{{ $message }}</div> // $message маг.переменная доступная только внутри @error
@enderror

// Отсутствие переменной $errors
Маршруты, не входящие в группу промежуточного программного обеспечения web,
не будут иметь соответствующей сессии. Им будет недоступна переменная $errors.
















*/