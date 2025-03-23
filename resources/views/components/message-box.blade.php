<style>
    .invBor::before {
        content: "";
        position: absolute;
        background-color: transparent;
        height: 10px;
        width: 20px;
        bottom: -0px;
        left: -20px;
        border-bottom-right-radius: 20px;
        box-shadow: 10px 0 0 0;
    }
</style>
<div class="flex w-full justify-start">
    <div class="p-2 bg-ternary rounded-r-lg rounded-tl-lg text-ternary min-w-[20px] w-auto max-w-4xl text-wrap invBor mb-2 text-justify relative">
        <div class="text-gray-800">
            {{ $slot }}
        </div>
    </div>
</div>