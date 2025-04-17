@extends("passwordless::layouts.app")

@section("content")
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto h-screen lg:py-0">
        @if(session()->has(["status", "message"]))
            <x-passwordless::alert
                    :status="session('status')"
                    :message="session('message')"
            />
        @endif

        <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
            <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
            Flowbite
        </a>
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    @lang("passwordless::app.login.title")
                </h1>
                <form class="space-y-4 md:space-y-6" method="POST" action="{{ route("login.send") }}">
                    @csrf

                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            @lang("passwordless::app.login.labels.email")
                        </label>
                        <input type="email" name="email" id="email"
                               class="bg-gray-50 border border-gray-300 @error("email") border-red-500 dark:border-red-500 @enderror text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="@lang("passwordless::app.login.placeholders.email")" required="">
                        @error("email")
                        <span class="mt-2 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col items-start">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="remember" aria-describedby="remember" type="checkbox"
                                       name="remember_me"
                                       class="w-4 h-4 border border-gray-300 rounded-lg bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800"
                                >
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="remember"
                                       class="text-gray-500 dark:text-gray-300">@lang("passwordless::app.login.labels.remember-me")</label>
                            </div>
                        </div>

                        @error("remember_me")
                            <span class="mt-2 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        @lang("passwordless::app.login.sign-in")
                    </button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        @lang("passwordless::app.login.no-account")
                        <a href="{{ route("register") }}"
                           class="font-medium text-blue-600 hover:underline dark:text-blue-500">@lang("passwordless::app.register.sign-up")</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection
