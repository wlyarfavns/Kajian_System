<x-organizer-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('organizer.kajian.index') }}" class="mr-4 text-gray-400 hover:text-gray-600">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            Kelola Peserta Kajian
        </div>
    </x-slot>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-lg font-bold text-brand-ink">Daftar Peserta</h2>
                <p class="text-sm text-brand-ink-soft">Melihat daftar jamaah yang mendaftar dan hadir pada kajian ini.</p>
            </div>
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                <form action="{{ url()->current() }}" method="GET" class="w-full sm:w-auto relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="search" class="h-4 w-4 text-gray-400"></i>
                    </div>
                    <input type="search" id="searchInput" name="q" value="{{ request('q') }}" {{ request('q') ? 'autofocus' : '' }} onfocus="var temp_value=this.value; this.value=''; this.value=temp_value;" oninput="clearTimeout(this.delay); this.delay = setTimeout(() => this.form.requestSubmit(), 500);" placeholder="Cari nama atau email..." class="pl-10 border-gray-300 rounded-lg text-sm text-brand-ink focus:ring-brand-emerald-800 focus:border-brand-emerald-800 w-full sm:w-64">
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 whitespace-nowrap">
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Nama Peserta</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Waktu Daftar</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Status Kehadiran</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($participants as $attendee)
                        <tr class="hover:bg-gray-50 transition whitespace-nowrap">
                            <td class="px-6 py-4">
                                <div class="font-medium text-brand-ink">{{ $attendee->user->name }}</div>
                                <div class="text-sm text-brand-ink-soft mt-1">N/A</div> <!-- Assume gender not stored in User model for now -->
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-brand-ink">{{ $attendee->user->email }}</div>
                                <div class="text-xs text-brand-ink-soft mt-1">N/A</div> <!-- Assume phone not stored -->
                            </td>
                            <td class="px-6 py-4 text-sm text-brand-ink">
                                {{ $attendee->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($attendee->status === 'registered')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-gold-soft text-brand-gold-text">Belum Hadir</span>
                                @elseif($attendee->status === 'attended')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-emerald-100 text-brand-emerald-950">Hadir</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Dibatalkan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($attendee->status === 'registered')
                                    <!-- Here we can add a check-in form later if needed -->
                                    <button type="button" class="inline-flex items-center px-3 py-1.5 border border-brand-emerald-900 text-sm font-medium rounded-md text-white bg-brand-emerald-900 hover:bg-brand-emerald-950 transition">
                                        <i data-lucide="check-circle" class="w-4 h-4 sm:mr-1.5"></i>
                                        <span class="hidden sm:inline">Check In</span>
                                    </button>
                                @else
                                    <button type="button" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-brand-ink bg-white hover:bg-gray-50 transition" disabled>
                                        <i data-lucide="check" class="w-4 h-4 sm:mr-1.5 text-brand-emerald-900"></i>
                                        <span class="hidden sm:inline">Selesai</span>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-brand-ink-soft">
                                Belum ada peserta yang mendaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($participants->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $participants->links() }}
            </div>
        @endif
    </div>
</x-organizer-layout>
