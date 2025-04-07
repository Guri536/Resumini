<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Page Title -->
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-[Montserrat] text-text-primary mb-4">How Reshumi Works</h1>
            <div class="text-lg md:text-xl text-white/80 italic">
                "Unlock Your Career Potential with Reshumi"
            </div>
            <div class="h-1 w-2/3 bg-gradient-to-r from-[#D6645D] via-[#c1a8ea] to-[#439DDF] mx-auto mt-6"></div>
        </div>

        <!-- Introduction Section -->
        <div class="mx-auto max-w-4xl mb-16 text-center">
            <p class="text-lg text-text-primary mb-6">
                Resumini simplifies resume creation with the power of Reshumi, our intelligent AI. Get a professional, ATS-friendly resume in minutes, tailored to your unique skills and experience.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-8 mb-16">
            <!-- Feature Card 1 -->
            <x-how-card>
                <x-slot name='title'>
                    Start the Conversation
                </x-slot>
                Begin by chatting with Reshumi. Our AI will guide you through a series of questions to gather information about your work history, education, skills, and career goals.
            </x-how-card>
            <x-how-card>
                <x-slot name='title'>
                    Share Your Experience
                </x-slot>
                Provide details about your previous roles, responsibilities, and achievements. Reshumi uses this information to craft compelling descriptions that highlight your strengths.
            </x-how-card>
            <x-how-card>
                <x-slot name='title'>
                    Reshumi's Magic
                </x-slot>
                Reshumi analyzes your input, optimizing it for ATS (Applicant Tracking Systems) and incorporating industry-specific keywords to increase your visibility to recruiters.
            </x-how-card>
            <x-how-card>
                <x-slot name='title'>
                    Download and Land Your Dream Job
                </x-slot>
                Download your polished resume in your preferred format (e.g., PDF, DOCX). Get ready to impress employers and take the next step in your career!
            </x-how-card>
        </div>

    </div>
</x-app-layout>