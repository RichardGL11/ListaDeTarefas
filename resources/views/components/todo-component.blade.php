<div>
    @forelse($todos as $todo)
        <div
                class="m-4 bg-white w-[300px] rounded-[30px] flex flex-col justify-center hover:shadow-lg min-h-[280px] dark:bg-gray-800 dark:text-white items-start relative group"
        >
            <div class="m-5">

                <div class="mt-4 text-left w-full mb-3">
                    <h2 class="text-2xl roboto-mono-500 text-gray-800 dark:text-white">
                        {{$todo->title}}
                    </h2>
                    <h6 @class([
                         "text-2xl",
                         "roboto-mono-500",
                        "text-green-500" =>  $todo->status == \App\Enums\TodoStatusEnum::Completed,
                        "text-yellow-500" => $todo->status == \App\Enums\TodoStatusEnum::Pending,
                        ])>
                        {{strtoupper($todo->status->value)}}
                    </h6>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                        {{$todo->description}}
                    </p>

                    <p class="mt-2">{{\Carbon\Carbon::parse($todo->created_at)->format('d/M/Y')}}</p>
                </div>
                <br>
                <div class="absolute bottom-0 left-0 right-0 m-4 flex justify-between items-center">
                    <a href="{{ route('todos.edit', $todo) }}">
                        <div
                                class="bg-gray-300 dark:bg-gray-700 w-10 h-10 rounded-full flex justify-center items-center hover:ring-4 ring-gray-200 dark:ring-green-400 transition duration-700 ease-in-out"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 18.256 18.256">
                                <g transform="translate(5.363 5.325)">
                                    <path d="M14.581,7.05,7.05,14.581" transform="translate(-7.05 -7.012)" fill="none" stroke="#0D1117" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                    <path d="M10,7l5.287.037.038,5.287" transform="translate(-7.756 -7)" fill="none" stroke="#0D1117" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                </g>
                                <path d="M0,0H18.256V18.256H0Z" fill="none"></path>
                            </svg>
                        </div>
                    </a>

                    <form method="POST" action="{{ route('todos.destroy', $todo) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')">
                            <div
                                    class="bg-red-300 dark:bg-red-700 w-10 h-10 rounded-full flex justify-center items-center hover:ring-4 ring-red-200 dark:ring-red-400 transition duration-700 ease-in-out"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#0D1117" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    @empty
        <p>There is no Todo yet</p>
    @endforelse
    <ul class="justify-center">
        {{$todos->appends(request()->query())->links()}}
        </ul>
</div>
