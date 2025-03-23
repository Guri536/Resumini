<style>
    .invBor2::after {
        content: "";
        position: absolute;
        background-color: transparent;
        height: 10px;
        width: 20px;
        bottom: -0px;
        right: -20px;
        border-bottom-left-radius: 20px;
        box-shadow: -10px 0 0 0;
    }
</style>
<div class="flex w-full justify-end">
    <div class="p-2 bg-quat rounded-l-lg rounded-tr-lg text-quat min-w-[20px] w-auto max-w-4xl text-wrap invBor2 mb-2 text-justify relative">
        <div class="text-gray-800">
            {{ $slot }}
        </div>
    </div>
</div>