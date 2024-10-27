@use(App\Enums\TaskPriority)
@use(App\Enums\TaskStatus)

@section('title', 'وظایف')

<div class="flex flex-col gap-5">
    <div class="flex p-1 gap-3">
        @if( session("message") )
            <div class="bg-info text-white p-1 rounded">{{ session()->get("message") }}</div>
        @endif
        @if( count($errors) > 0 )
            @foreach($errors as $error)
                <div class="bg-danger p-1 rounded">{{$error}}</div>
            @endforeach
       @endif
    </div>

    <div class="border-b">
        <h1 class="text-3xl mb-5">
            وظیفه جدید
        </h1>
        <form wire:submit.prevent>
            <input type="hidden" wire:model="task_id">
            <div class="flex flex-wrap p-3 gap-2">
                <div class="flex flex-col gap-2 p-2">
                    <label for="title">
                        <span>
                            عنوان
                        </span>
                        <span class="text-danger">
                            *
                        </span>
                    </label>
                    <div>
                        <x-input id="title" name="title" wire:model="title"/>
                    </div>
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <label for="description">توضیحات</label>
                    <div>
                        <x-input id="description" name="description" wire:model="description"/>
                    </div>
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <label for="due_date">تاریخ پایان</label>
                    <div>
                        <x-input id="due_date" name="due_date" wire:model="due_date" data-jdp data-jdp-min-date="today"/>
                    </div>
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <label for="priority">اولویت</label>
                    <div>
                        <select id="priority" name="priority" class="border rounded p-1" wire:model="priority">
                            @foreach(TaskPriority::values() as $priority)
                                <option value="{{$priority}}" {{ TaskPriority::from($priority)->name == TaskPriority::normal->name ? 'selected' : '' }}>
                                    {{ __(TaskPriority::from($priority)->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <div class="p-2 flex gap-2 items-end h-full">
                        @if($updateMode)
                            <button class="btn bg-warning" type="button" wire:click.prevent="update">
                                ویرایش وظیفه
                            </button>
                            <button class="btn bg-light" type="button" wire:click.prevent="clearInputs">
                                ریست
                            </button>
                        @else
                            <button class="btn bg-success" type="button" wire:click.prevent="store">
                                ثبت وظیفه
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div>
        <h1 class="text-3xl mb-5">
            وظایف
        </h1>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2">
            @if( $tasks->isEmpty() )
                <div class="md:col-span-2 lg:col-span-3 xl:col-span-4 bg-danger rounded p-1 py-3 text-center">
                    وظیفه‌ای وجود ندارد
                </div>
            @else
                @foreach( $tasks as $task )
                    <div class="flex flex-col rounded-lg shadow border border-solid border-black p-2 gap-4 @if($task->id == $task_id) bg-gray-200 @endif">
                        {{-- header --}}
                        <div class="flex justify-between border-b pb-2 border-b-black">
                            <div class="gap-2">
                                <button
                                    type="button"
                                    class="btn bg-info"
                                    wire:click.prevent="patchStatus({{$task->id}}, '{{ TaskStatus::pending->value }}')">
                                    فعال
                                </button>
                                <button
                                    type="button"
                                    class="btn bg-danger"
                                    wire:click.prevent="patchStatus({{$task->id}}, '{{ TaskStatus::suspended->value }}')">
                                    تعویق
                                </button>
                                <button
                                    type="button"
                                    class="btn bg-success"
                                    wire:click.prevent="patchStatus({{$task->id}}, '{{ TaskStatus::completed->value }}')">
                                    تکمیل
                                </button>
                            </div>
                            <div class="gap-2">
                                <button type="button" wire:click.prevent="edit({{$task->id}})" class="btn bg-warning"> ویرایش </button>
                                <button type="button" wire:click.prevent="delete({{$task->id}})" class="btn bg-danger"> حذف </button>
                            </div>
                        </div>

                        {{-- body --}}
                        <div class="flex flex-col gap-4">
                            <div class="w-full flex justify-between">
                                <div class="flex flex-col">
                                    <strong>وضعیت</strong>
                                    <x-inline.task-status :status="$task->status"/>
                                </div>
                                <div class="flex flex-col">
                                    <strong>اولویت</strong>
                                    <x-inline.task-priority :status="$task->priority"/>
                                </div>
                            </div>

                            <div class="flex justify-between">
                                <div>
                                    <strong>عنوان</strong>
                                    <div>{{ $task->title }}</div>
                                </div>
                                <div>
                                    <strong>تاریخ پایان</strong>
                                    <div class="flex w-full justify-end">
                                        @if( $task->due_date != null)
                                            @if( \Carbon\Carbon::hasFormat($task->due_date, 'Y-m-d H:i:s') )
                                                <div class="flex flex-col items-end">
                                                    <x-inline.datetime :datetime="$task->due_date" format="Y/m/d" />
                                                    <x-inline.datetime :datetime="$task->due_date" format="H:i:s" />
                                                </div>
                                            @elseif( \Carbon\Carbon::hasFormat($task->due_date, 'Y-m-d') )
                                                <div class="flex flex-row-reverse gap-2">
                                                    <x-inline.datetime :datetime="$task->due_date" format="Y/m/d" />
                                                </div>
                                            @else
                                                <div>
                                                    تاریخ نامعتبر
                                                </div>
                                            @endif
                                        @else
                                            <div>
                                                بدون تاریخ
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div>
                                <strong>توضیحات</strong>
                                <div class="line-clamp-1">
                                    @if( $task->description != null )
                                        {{ $task->description }}
                                    @else
                                        بدون توضیحات
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- footer --}}
                        <div class="flex justify-between border-t pt-2 border-t-black">
                            <div>
                                <strong>تاریخ ساخت</strong>
                                <div class="flex flex-row-reverse gap-2">
                                    <x-inline.datetime :datetime="$task->created_at" format="Y/m/d" />
                                    <x-inline.datetime :datetime="$task->created_at" format="H:i:s" />
                                </div>
                            </div>
                            <div>
                                <strong>تاریخ آخرین ویرایش</strong>
                                <div class="flex flex-row-reverse gap-2">
                                    <x-inline.datetime :datetime="$task->updated_at" format="Y/m/d" />
                                    <x-inline.datetime :datetime="$task->updated_at" format="H:i:s" />
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

@section('script')
    <script>
        document.addEventListener('livewire:load', function () {
            window.Echo.channel('tasks-channel')
                .listen('TasksHasChanges', () => {
                    Livewire.emit('$refresh');
                });
        });

    </script>
@endsection
