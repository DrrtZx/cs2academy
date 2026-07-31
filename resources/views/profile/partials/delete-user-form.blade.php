<section class="space-y-6">
    <header>
        <h2 style="font-size:1.1rem;font-weight:800;color:#ff5f5f;margin-bottom:0.4rem;">
            Hapus Akun
        </h2>

        <p style="font-size:0.85rem;color:var(--text2);line-height:1.6;">
            Setelah akun kamu dihapus, semua data progress kursus dan riwayat paket coaching akan terhapus secara permanen.
        </p>
    </header>

    <button type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        style="background:rgba(255,80,80,0.12);color:#ff5f5f;border:1px solid rgba(255,80,80,0.3);padding:9px 18px;border-radius:10px;font-size:0.85rem;font-weight:700;cursor:pointer;transition:all .2s;"
        onmouseover="this.style.background='rgba(255,80,80,0.22)'"
        onmouseout="this.style.background='rgba(255,80,80,0.12)'"
    >
        Hapus Akun Permanen
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" style="padding:1.75rem;background:var(--bg2);color:var(--text);">
            @csrf
            @method('delete')

            <h2 style="font-size:1.2rem;font-weight:800;color:var(--text);margin-bottom:0.5rem;">
                Apakah kamu yakin ingin menghapus akun?
            </h2>

            <p style="font-size:0.85rem;color:var(--text2);line-height:1.6;margin-bottom:1.25rem;">
                Semua data akan dihapus permanen. Masukkan kata sandi kamu untuk mengonfirmasi penghapusan akun.
            </p>

            <div style="margin-bottom:1.5rem;">
                <label for="password" class="sr-only">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Masukkan kata sandi kamu..."
                    style="width:100%;background:var(--bg3);border:1px solid var(--border);border-radius:10px;padding:11px 14px;color:var(--text);font-size:0.9rem;outline:none;"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div style="display:flex;justify-content:flex-end;gap:10px;">
                <button type="button" x-on:click="$dispatch('close')"
                    style="background:var(--bg3);border:1px solid var(--border);color:var(--text2);padding:9px 16px;border-radius:10px;font-size:0.85rem;font-weight:700;cursor:pointer;">
                    Batal
                </button>

                <button type="submit"
                    style="background:#ff5f5f;color:#fff;border:none;padding:9px 18px;border-radius:10px;font-size:0.85rem;font-weight:700;cursor:pointer;box-shadow:0 8px 20px -6px rgba(255,80,80,0.5);">
                    Hapus Permanen
                </button>
            </div>
        </form>
    </x-modal>
</section>
