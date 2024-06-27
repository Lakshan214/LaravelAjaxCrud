Laravel Beginner to Advanced Guide
1. මුලික සැකසීම්
Laravel ස්ථාපනය කිරීම

1. Composer ස්ථාපනය කරන්න: Laravel ස්ථාපනය කිරීම සඳහා Composer අත්‍යවශ්‍ය වේ.

composer global require laravel/installer
2. නව Laravel project එකක් සාදන්න:

laravel new project-name
cd project-name
පිරිසැකසුම්

1. .env ගොනුව සකස් කරන්න: Database, APP_KEY වැනි පිරිසැකසුම් සකස් කරන්න.

cp .env.example .env
php artisan key:generate
2. Migration එකක් ක්‍රියාත්මක කරන්න:

php artisan migrate
2. මුලික සංකල්ප
Routes
1. Route එකක් නිර්මාණය කරන්න:

Route::get('/welcome', function () {
    return view('welcome');
});
2. Controller එකක් සාදන්න:

php artisan make:controller WelcomeController
public function index()
{
    return view('welcome');
}
Route::get('/welcome', [WelcomeController::class, 'index']);
Views
1. Blade Template එකක් භාවිතා කරන්න:

<h1>Welcome to Laravel</h1>
3. මූලික CRUD ක්‍රියාකාරකම්
Models සහ Migrations
1. Model සහ Migration එකක් සාදන්න:

php artisan make:model Post -m
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('content');
    $table->timestamps();
});
2. Migration එකක් ක්‍රියාත්මක කරන්න:

php artisan migrate
Controller සහ Routes
1. Resource Controller එකක් සාදන්න:

php artisan make:controller PostController --resource
Route::resource('posts', PostController::class);
2. CRUD ක්‍රියාකාරකම්:

public function index()
{
    $posts = Post::all();
    return view('posts.index', compact('posts'));
}

public function create()
{
    return view('posts.create');
}

public function store(Request $request)
{
    $post = new Post();
    $post->title = $request->title;
    $post->content = $request->content;
    $post->save();
    return redirect()->route('posts.index');
}

public function show(Post $post)
{
    return view('posts.show', compact('post'));
}

public function edit(Post $post)
{
    return view('posts.edit', compact('post'));
}

public function update(Request $request, Post $post)
{
    $post->title = $request->title;
    $post->content = $request->content;
    $post->save();
    return redirect()->route('posts.index');
}

public function destroy(Post $post)
{
    $post->delete();
    return redirect()->route('posts.index');
}
Views
1. Create, Edit, Show, Index views නිර්මාණය කරන්න:

@foreach($posts as $post)
    <h2><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h2>
    <p>{{ $post->content }}</p>
@endforeach
<form action="{{ route('posts.store') }}" method="POST">
    @csrf
    <input type="text" name="title" placeholder="Title">
    <textarea name="content" placeholder="Content"></textarea>
    <button type="submit">Create</button>
</form>
4. Advanced සංකල්ප
Middleware
1. Middleware එකක් සාදන්න:

php artisan make:middleware CheckAge
public function handle($request, Closure $next)
{
    if ($request->age <= 200) {
        return redirect('home');
    }
    return $next($request);
}

protected $routeMiddleware = [
    'age' => \App\Http\Middleware\CheckAge::class,
];
Events and Listeners
1. Event එකක් සහ Listener එකක් සාදන්න:

php artisan make:event OrderShipped
php artisan make:listener SendShipmentNotification --event=OrderShipped
namespace App\Events;

use App\Models\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class OrderShipped
{
    use Dispatchable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}

namespace App\Listeners;

use App\Events\OrderShipped;

class SendShipmentNotification
{
    public function handle(OrderShipped $event)
    {
        // Send notification code
    }
}

protected $listen = [
    'App\Events\OrderShipped' => [
        'App\Listeners\SendShipmentNotification',
    ],
];

event(new OrderShipped($order));
Queues
1. Queue Job එකක් නිර්මාණය කරන්න:

php artisan make:job ProcessPodcast
namespace App\Jobs;

use App\Models\Podcast;

class ProcessPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $podcast;

    public function __construct(Podcast $podcast)
    {
        $this->podcast = $podcast;
    }

    public function handle()
    {
        // Processing code
    }
}

ProcessPodcast::dispatch($podcast);
Task Scheduling
1. Task එකක් Schedule කරන්න:

protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        DB::table('recent_users')->delete();
    })->daily();
}
Policies
1. Policy එකක් නිර්මාණය කරන්න:

php artisan make:policy PostPolicy
namespace App\Policies;

use App\Models\User;
use App\Models\Post;

class PostPolicy
{
    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post)
    {
        return $user.id === $post.user_id;
    }
}

protected $policies = [
    'App\Models.Post' => 'App\Policies\PostPolicy',
];

$this->authorize('update', $post);
