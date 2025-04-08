<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Page Title -->
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-[Montserrat] text-text-primary mb-4">Frequently Asked Questions</h1>
            <div class="text-lg md:text-xl text-white/80 italic">
                "Get to know Reshumi"
            </div>
            <div class="h-1 w-2/3 bg-gradient-to-r from-[#D6645D] via-[#c1a8ea] to-[#439DDF] mx-auto mt-6"></div>
        </div>

        <div class="flex isolate mx-3 my-5 md:mx-30 lg:mx-60 md:my-10 w-auto rounded-[30px] p-4 justify-center bg-black/30 shadow-md shadow-white/20 backdrop-blur-xl text-shadow-[0_35px_35px_rgb(0_0_0_/_0.25)] text-text-primary">
            <div class="">
            In order to get your questions answered, contact us through support. <a href="{{ route('support') }}" class="text-blue-200 hover:underline">Click here.</a>
            </div>
        </div>

        <div class="flex isolate mx-3 my-5 md:mx-30 lg:mx-60 md:my-10 w-auto rounded-[30px] p-10 bg-black/30 shadow-md shadow-white/20 backdrop-blur-xl text-shadow-[0_35px_35px_rgb(0_0_0_/_0.25)] text-text-primary">
            <div class="">
                <div class="text-xl font-semibold mb-4">Frequently Asked Questions</div>
                <x-faqcard>
                    <x-slot name="title">How does Reshumi AI work?</x-slot>
                    Our AI analyzes your experience and the job requirements to create a tailored resume that highlights your most relevant skills and achievements.
                </x-faqcard>
                <x-faqcard>
                    <x-slot name="title">Is my information secure?</x-slot>
                    Yes, we use enterprise-grade encryption to protect your data. We never share your information with third parties.
                </x-faqcard>
                <x-faqcard>
                    <x-slot name="title">What is Resumini and Reshumi AI?</x-slot>
                    Resumini is a platform that helps you create professional resumes effortlessly. Reshumi AI is our intelligent agent that understands your experience and job requirements to generate a tailored resume for you.
                </x-faqcard>
                <x-faqcard>
                    <x-slot name="title">How do I start creating my resume?</x-slot>
                    Simply start a conversation with Reshumi AI. It will guide you through the process by asking relevant questions about your work history, skills, and the type of job you're applying for.
                </x-faqcard>
                <x-faqcard>
                    <x-slot name="title">What file formats can I download my resume in?</x-slot>
                    You can download your resume in multiple formats, including PDF, TEX (LaTeX source file), DOC (Microsoft Word), and HTML.
                </x-faqcard>
                <x-faqcard>
                    <x-slot name="title">What happens if there's an error generating my PDF?</x-slot>
                    If an error occurs while generating your PDF, Reshumi AI will provide you with the TEX file of your resume, which you can download. You will also receive an Overleaf API link, allowing you to easily compile and edit your resume on the Overleaf website.
                </x-faqcard>
                <x-faqcard>
                    <x-slot name="title">Do I need to know LaTeX to use Resumini?</x-slot>
                    No, you don't need any prior knowledge of LaTeX. Reshumi AI handles the LaTeX compilation in the background to generate your resume in your preferred format. The TEX file and Overleaf link are provided as a backup and for advanced users who might want further customization.
                </x-faqcard>
                <x-faqcard>
                    <x-slot name="title">Can I customize the resume generated by Reshumi AI?</x-slot>
                    Yes, while Reshumi AI creates a tailored resume, you have the flexibility to further customize it after downloading it in your preferred format (DOC, HTML, or by editing the TEX file on Overleaf).
                </x-faqcard>
                <x-faqcard>
                    <x-slot name="title">Is there a limit to the number of resumes I can create?</x-slot>
                    Currently, there is no limit to the number of resumes you can create.
                </x-faqcard>
                <x-faqcard>
                    <x-slot name="title">What kind of information should I provide to Reshumi AI?</x-slot>
                    To get the best results, provide detailed information about your work experience (job titles, responsibilities, achievements), education, skills, and any specific requirements mentioned in the job description you're targeting.
                </x-faqcard>
            </div>
        </div>

    </div>
</x-app-layout>