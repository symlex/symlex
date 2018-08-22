# Tradeoffs

## Potential reasons to use Symlex

- Symlex is designed to be simple with few concepts to understand
- Using Symlex results is more maintainable and testable code that is fundamental for agile development
- It has proven to be well suited for rapidly building microservices, CLI and single-page applications
- It comes complete with working examples
- Built on top of well documented and tested standard components
- Contains everything to create full-featured Web applications: Service container, REST routing & Twig template engine
- Lower complexity and improved performance compared to Symfony standard edition and many other frameworks
- Plain classes are used wherever possible to avoid vendor lock-in and enable framework independent code reuse
- While you can use Symfony Components and any other PHP library out there, you can not use Symfony bundles as they 
make it easy to add tons of code to an application with very little work and understanding for what it does 
(bundles are nothing else than libraries that come with their own, hidden service container configuration and bootstrap code)
- Even if you choose not use Symlex, you might find lots of inspiration for your own projects

## Potential reasons to not use Symlex

- Symlex has a small community so far, see [history](../README.md)
- Development is mostly driven by the needs of specific applications (development started to have a high-performance 
replacement for FOSRestBundle)
- It is not good for developers who are not comfortable reading at least small amounts of framework code as not 
everything is documented 100% (you are welcome as ask for help via email and send additional docs as pull request)
- Symlex is completely not suitable if you would like to or need to work with existing Symfony bundles
- Symlex is not good if you prefer configuration over coding
- Copy and pasting code from Stack Overflow or the Symfony documentation often won't work without 
understanding it and adapting it a little e.g. when it comes to service configuration or routing
- Symlex still uses Silex for routing under the hood; a replacement for Silex is in development