<x-app-layout>
    <script type="text/javascript">
        var submitted = false;
    </script>
    <iframe name="hidden_iframe" id="hidden_iframe" style="display:none;" onload="if(submitted)  {window.location='{{ Route('supportSuccess') }}';}"></iframe>

    <div class="container mx-auto px-4 py-8 flex flex-col justify-center">
        <!-- Page Title -->
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-[Montserrat] text-text-primary mb-4">Contact Us</h1>
            <div class="text-lg md:text-xl text-white/80 italic">
                Get in touch with support
            </div>
            <div class="h-1 w-2/3 bg-gradient-to-r from-[#D6645D] via-[#c1a8ea] to-[#439DDF] mx-auto mt-6"></div>
        </div>

        <div class="w-1/2 self-center text-text-primary">
            <form action="https://docs.google.com/forms/u/0/d/e/1FAIpQLSeQl0mVrdQFIWbFGymdkGXVdOK2YGOUJSUy7w5Tp2EfPPoWHQ/formResponse" method="post" id="mG61Hd" target="hidden_iframe" onsubmit="submitted=true;">
                <div>
                    <label for="email" class="block text-lg font-bold mb-2">Your Email:</label>
                    <input type="email" id="email" class="shadow appearance-none border rounded w-3/4 md:w-1/2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" autocomplete="email" tabindex="0" jsname="YPqjbf" required dir="auto" name="entry.444196935" placeholder="Your Email Here">
                </div>

                <div class="mt-8">
                    <label for="subject" class="block text-lg font-bold mb-2">About:</label>
                    <div class="relative">
                        <select id="subject" name="entry.1880369479" class="block appearance-none w-3/4 md:w-1/2 bg-white border border-gray-300 hover:border-gray-400 py-2 px-4 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline text-gray-700" required>
                            <option value="" hidden>Please Select</option>
                            <option value="Account Issue">Account Issue</option>
                            <option value="Technical Support">Technical Support</option>
                            <option value="Feedback">General Feedback</option>
                            <option value="Business Inquiry">Business Inquiry</option>
                        </select>
                    </div>
                    <small class=" mt-1 block">Please select the topic that best describes your message.</small>
                </div>

                <div class="mt-8">
                    <label for="message" class="block text-lg font-bold mb-2">Your Message:</label>
                    <textarea id="message" rows='1' class="shadow appearance-none border rounded-md w-full h-auto text-gray-700 focus:outline-none focus:shadow-outline resize-none" name="entry.671862872" placeholder="Your Message Here"></textarea>
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-8">
                    Send Message
                </button>
            </form>
        </div>


    </div>

</x-app-layout>