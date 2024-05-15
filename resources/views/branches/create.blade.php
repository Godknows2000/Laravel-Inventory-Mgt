<x-layout>
    <x-splade-form :action="route('branches.store')" class="justify-center w-full px-5 py-5 mx-auto mt-16 space-y-4 bg-white md:w-6/12">
        <h1 class="text-xl font-semibold text-center">Create Branch</h1>

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-splade-input type="text" name="name" label="Name" class="w-full" />
        <x-splade-input type="text" name="phone" label="Phone" class="w-full" />
        <x-splade-input type="email" name="email" label="Email" class="w-full" />
        <x-splade-input type="text" name="address" label="Address" class="w-full" />
        <x-splade-submit
            class="w-full h-10 px-2 mt-5 font-sans font-semibold text-white transition bg-gray-800 rounded hover:bg-gray-200 hover:text-black md:w-28"
            :spinner="true" />
    </x-splade-form>
</x-layout>
