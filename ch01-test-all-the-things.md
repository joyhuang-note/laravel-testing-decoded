# Ch01: Test All The Things #

We’re better than that. We’re developers. Let’s not be cowboys.

p.9
—-----
The only time when it’s acceptable to instantiate a class inside of another class is when that object is what we refer to as a value-object, or a simple container with getters and setters that doesn’t do any real work.



p.12
—-----
when testing, you’ll repeatedly follow the same process:

1. Arrange
2. Act
3. Assert

Tip: Keep it simple: limit your constructors to dependency assignments.

p.13
—-----
Tip: Polymorphism allows you to split complex classes into small chunks, often referred to as sub-classes. Remember: the smaller the class, the easier it is to test.



p.16
—-----
Unit Testing
Model Testing
Integration Testing
Functional (Controller) Testing
Acceptance Testing

how do we successfully unit test this method, if it calls an external Mailer class? The answer is to use `mocks`, which we’ll cover extensively in this book. A mock allows us to fake the Mailer class, and write an expectation to ensure that the proper method is called.
