@extends("passwordless::layouts.app")

@section("content")
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto h-screen lg:py-0">
        <x-passwordless::alert
                :status="session('status') ?? true"
                :message="session('message') ?? __('passwordless::app.login.email.email-sent')"
                :subMessage="session('sub_message')"
        />
        <div>
            @if(session()->has("email"))
                <form method="POST" action="{{ route("login.send", ["email" => session("email")])}}">
                    @csrf

                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        @lang("passwordless::app.login.email.no-email-received")
                        <button type="submit"
                                class="font-medium text-blue-600 hover:underline dark:text-blue-500 cursor-pointer">
                            @lang("passwordless::app.login.email.resend")
                        </button>
                    </p>
                </form>
            @else
                <a href="{{ route("login") }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500 cursor-pointer">
                    @lang("passwordless::app.login.sign-in")
                </a>
            @endif
        </div>
    </div>
@endsection
