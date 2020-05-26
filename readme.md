# Assignment: Build a **Hearts** game for a job interview.

## Disclaimer

As I'm not a full time php developer, but more focused on being able to write multiple languages, frameworks, etc.  
I do realise that this code can be optimised a lot. Which would be something that would naturally come from teamwork within the company.

However, it should show that I am able to pick up a language, and complete the assignment, showing that a direction is chosen, build and executed.

To safe on time and complexity I chose to forgo using getters and setters.
While it looks more clean, it also removes readability in one off micro sized projects.  
With this in mind, almost all properties on the classes are set as public where needed using this workflow.  
As almost all project start out with a framework, or write their own framework, the workflow will become more optimised for production use.

## Run

Just run `composer hearts` or directly `php -S localhost:8000` from your console and open [http://localhost:8000](https://localhost:8000).
It should run its internal game and show the result.

Alternatively, you can run it through Homestead.
Duplicate the `Homestead.yaml.example` file, name it `Homestead.yaml` and run `vagrant up`.  
Make sure you add `127.0.0.1 hearts.test` to your hosts file. And then navigate your browser to `http://hearts.test`

## Test

I added a single test with 2 assertions. This is very basic and I didn't add a failing test (check if Exceptions are getting handled) due to time constraints on my part.
