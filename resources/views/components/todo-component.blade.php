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
                <a href="{{route('todos.edit',$todo)}}">
                    <div
                            class="bg-gray-300 dark:bg-gray-700 w-10 h-10 rounded-full absolute bottom-0 left-0 m-4 flex justify-center items-center hover:ring-4 ring-gray-200 dark:ring-green-400 hover:transition duration-700 ease-in-out"
                    >
                        <svg
                                id="Arrow.7"
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                viewBox="0 0 18.256 18.256"
                                style="transition:.3s"
                        >
                            <g
                                    id="Group_7"
                                    data-name="Group 7"
                                    transform="translate(5.363 5.325)"
                            >
                                <path
                                        id="Path_10"
                                        data-name="Path 10"
                                        d="M14.581,7.05,7.05,14.581"
                                        transform="translate(-7.05 -7.012)"
                                        fill="none"
                                        stroke="#0D1117"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                ></path>
                                <path
                                        id="Path_11"
                                        data-name="Path 11"
                                        d="M10,7l5.287.037.038,5.287"
                                        transform="translate(-7.756 -7)"
                                        fill="none"
                                        stroke="#0D1117"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                ></path>
                            </g>
                            <path
                                    id="Path_12"
                                    data-name="Path 12"
                                    d="M0,0H18.256V18.256H0Z"
                                    fill="none"
                            ></path>
                        </svg>
                    </div>
                </a>
            </div>
        </div>

    @empty
        <p>There is no Todo yet</p>
    @endforelse
    <ul class="justify-center">
        {{$todos->appends(request()->query())->links()}}
        </ul>
</div>
