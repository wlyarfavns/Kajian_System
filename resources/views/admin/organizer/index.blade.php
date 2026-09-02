<x-admin-layout>
    <x-slot name="header">
        Moderasi Penyelenggara
    </x-slot>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-brand-ink">Daftar Akun Penyelenggara</h2>
            <p class="text-sm text-brand-ink-soft">Kelola status verifikasi akun organizer agar mereka bisa membuat kajian publik.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Nama Organizer</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($organizers as $organizer)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-brand-ink">{{ $organizer->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $organizer->user->email ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($organizer->is_verified)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-emerald-100 text-brand-emerald-950">Terverifikasi</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Belum Diverifikasi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.organizer.verify', $organizer->id) }}" method="POST" class="inline">
                                    @csrf
                                    @if($organizer->is_verified)
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-brand-ink bg-white hover:bg-gray-50 transition" title="Cabut Verifikasi">
                                            <i data-lucide="shield-x" class="w-4 h-4 sm:mr-1.5 text-brand-danger"></i>
                                            <span class="hidden sm:inline">Cabut Verifikasi</span>
                                        </button>
                                    @else
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-brand-emerald-900 hover:bg-brand-emerald-950 transition shadow-sm">
                                            <i data-lucide="shield-check" class="w-4 h-4 mr-2"></i> Verifikasi Sekarang
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-brand-ink-soft">Belum ada penyelenggara.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($organizers->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 flex justify-center">
                {{ $organizers->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
