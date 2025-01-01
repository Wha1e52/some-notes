"""
The order of middleware classes is very important because each middleware can depend
on data set by another middleware that was executed previously. Middleware is applied
for requests in order of appearance in MIDDLEWARE, and in reverse order for responses.

"""