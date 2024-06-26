@include('layout.app')
<style>
    .background-image {
        background-image: url('images/bg-1.jpg'); /* Replace with your image path */
        background-size: cover;
        background-position: center;
    }
</style>
<div class="min-h-screen background-image flex flex-col justify-center py-12 sm:px-6 lg:px-8 px-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img class="mx-auto h-12 w-12 rounded-full" src="{{asset('images/fox.png')}}" alt="Workflow">
        <h2 class="mt-6 text-center text-white text-3xl leading-9 font-extrabold text-gray-900">
            Inventory Stock Manager
        </h2>
        <h2 class="mt-6 text-center text-white text-2xl leading-9 font-extrabold text-gray-900">
            Sign in to your account
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form method="post" action="{{route('login')}}">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium leading-5  text-gray-700">Email address</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="email" name="email" placeholder="user@example.com" type="email" required="" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                    </div>
                </div>

                <div class="mt-6">
                    <label for="password" class="block text-sm font-medium leading-5 text-gray-700">Password</label>
                    <div class="mt-1 rounded-md shadow-sm">
                        <input id="password" name="password" type="password" required="" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" value="1" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                        <label for="remember_me" class="ml-2 block text-sm leading-5 text-gray-900">Remember me</label>
                    </div>

                    <div class="text-sm leading-5">
                        <a href="{{route('password.request')}}"
                           class="font-medium text-blue-500 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <div class="mt-6">
                    <span class="block w-full rounded-md shadow-sm">
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Sign in
                        </button>.
                    </span>
                </div>
                <p class="mt-2 text-center text-sm leading-5 text-blue-500 max-w">
                    Or
                    <a href="{{route('register')}}"
                    class="font-medium text-blue-500 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                        create a new account
                    </a>
                </p>
            </form>

        </div>
    </div>
</div>
