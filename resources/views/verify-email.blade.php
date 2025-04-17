@extends("passwordless::layouts.app")

@section("content")
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto h-screen lg:py-0">
        <x-passwordless::alert
                :status="true"
                :message="session('message') ?? __('passwordless::app.email-verification.email-sent')"
                :subMessage="__('passwordless::app.email-verification.message')"
        />
        <div>
            <form action="{{ route("verification.send") }}" method="POST">
                @csrf

                <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                    @lang("passwordless::app.email-verification.no-email-received")
                    <button type="submit"
                            class="font-medium text-blue-600 hover:underline dark:text-blue-500 cursor-pointer">
                        @lang("passwordless::app.email-verification.resend")
                    </button>
                </p>
            </form>
        </div>
    </div>
@endsection
