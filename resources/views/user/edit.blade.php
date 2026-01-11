<x-app-layout>
    <x-slot  name="header">
        User Edit
    </x-slot>

    <div class="overflow-y-auto h-full
            [&::-webkit-scrollbar]:w-2
            [&::-webkit-scrollbar-track]:rounded-full
            [&::-webkit-scrollbar-track]:bg-gray-100
            [&::-webkit-scrollbar-thumb]:rounded-full
            [&::-webkit-scrollbar-thumb]:bg-gray-300
            dark:[&::-webkit-scrollbar-track]:bg-neutral-700
            dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500"
    >

        <div class="bg-[#F7F9FC] h-full w-full flex flex-col px-[33px] py-[28px] overflow-y-auto min-h-[100vh]">

            <user-edit sanctum_token="{{ $sanctum_token }}" :user="{{ $user }}" ></user-edit>

        </div>

    </div>
</x-app-layout>
