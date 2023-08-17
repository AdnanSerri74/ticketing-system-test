# Test Feedback

## Accomplishments

I've managed to accomplish loads of features, and in some cases I went even further.

- Project Structure, **so close to Laravel Framework**.
- Built a simple <code>**Router**</code> class with a seperated <code>web/routes.php</code> file.
- Built **simple, multi-methods** Controllers in a way that each <code>Controller</code> has the ability to handle multiple requests.
- Developed a teeny-tiny **Model Manager** that can provide multiple actions related to **Database**.
  > - <code>Model::class</code> - <code>app\Core</code>.
  > - <code>Modeling trait</code> - <code>app\Core\Traits</code>.
  > - <code>Builder::class</code> - <code>app\Core</code>.
  > - <code>Paginator::class</code> - <code>app\Core</code>.
- Provided control over many Configurations.
  > By populating to <code>.env</code> file and <code>config/app.php</code> file.
- Seperated between **Views** and **Controllers**.
  > Meaning **no PHP Logic** is written in a <code>.view.php</code> files.
- Sending Notifications by <code>PHPMailer</code> that implemented in <code>app\Notifications\Drivers\MailDriver</code> class.
  > Switch to any other <code>Driver</code> with ease from <code>config/app.php</code>, yet you need to **Provide** your <code>CustomDriver</code> class and extend <code>app\Notifications\Driver</code> class.
- Securing projects files by moving the project starting point to the <code>public/index.php</code>

- Applying **PRG Pattern** i.e **Post Redirect Get** for security concerns.
- Applying a simple and basic example of Containers.
  > - <code>Container::class</code> - <code>app\Core</code>
  > - <code>App::class</code> - <code>app\Core</code>
  > - Used <code>DB::class</code> as an example of usage _(bind, resolve)_.
  >   -- <code>bind()</code> - <code>bootstrap.php</code>
  >   -- <code>resolve()</code> - <code>Builder::class</code> - <code>app\Core\Builder</code>
- Middlewares and Authentication implementation .

  > - <code>Auth::class</code> - <code>app\Core</code>
  > - <code>Authenticator::class</code> - <code>app\Core</code>
  > - <code>Session::class</code> - <code>app\Core</code>
  > - <code>Authenticated::class</code> - <code>app\Core\Middleware</code>
  > - <code>Guest::class</code> - <code>app\Core\Middleware</code>
  > - <code>Middleware::class</code> - <code>app\Core\Middleware</code>

- Created a FileUploader to handle any upload.
  > - <code>FileUploader::class</code> - <code>app\Core</code>
  > - Uploading example is implemented in <code>app\Http\Controllers\Guest\GuestController::class</code>

---

## Incomplete Points and Features

- **Validation** implementation.
- **(CSRF) attacks** in terms of security.
- **Dowloading** Tickets' Files feature.
- **Navigators** in front-end pages.
- **A Well-Designed** pages.
- **A Well-Designed** email template.
