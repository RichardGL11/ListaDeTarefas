<x-app-layout>
    <div>
        <section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Todo: {{$todo->id}}</h2>

            <form action="{{route('todos.update',$todo)}}" method="POST">
                @method('PUT')
                @csrf
                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                    <div>
                        <label class="text-gray-700 dark:text-gray-200" for="username">Title</label>
                        <input name="title" value="{{$todo->title}}" id="title" type="text"
                               class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                        <div class="text-red-500">@error('title') {{ $message }} @enderror</div>
                    </div>

                    <div>
                        <label class="text-gray-700 dark:text-gray-200" for="description">Description</label>
                        <input name="description" value="{{$todo->description}}" id="description" type="text"
                               class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                        <div class="text-red-500">@error('description') {{ $message }} @enderror</div>
                    </div>

                    <div>
                        <label class="text-gray-700 dark:text-gray-200" for="status">Status</label>
                        <select name="status" class="mt-2">
                            <option  value="">Select...</option>
                            @foreach($status as $case)
                                <option value="{{ $case->value }}">
                                    {{ $case->name }}
                                </option>
                                <p>{{$case->value}}</p>
                            @endforeach
                        </select>
                        <div class="text-red-500">@error('status') {{ $message }} @enderror</div>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button
                        class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">
                        Update
                    </button>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
