import GuestLayout from "@/Layouts/GuestLayout";
import { Button } from "@/Components/ui/button";
import { Head, Link, useForm, usePage } from "@inertiajs/react";
import { FormEventHandler } from "react";

export default function VerifyEmail({ status }: { status?: string }) {
    const { post, processing } = useForm({});

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route("verification.send"));
    };
    const page = usePage();

    return (
        <GuestLayout>
            <Head title="Email Verification" />

            <section className="px-8 py-4 w-[calc(40vw-6rem)]">
                <h1 className="text-[3.25rem] font-medium">
                    Terima kasih telah mendaftar! 🎉
                </h1>
                <p>
                    Kami baru saja mengirimkan email verifikasi ke:
                    {page.props.auth.user.email}
                </p>

                <p>
                    Silakan periksa kotak masuk (atau folder spam) dan klik
                    tautan untuk memverifikasi alamat email Anda. Langkah ini
                    membantu kami menjaga keamanan akun Anda.
                </p>

                <h5>💡 Tidak menerima email?</h5>
                <ul>
                    <li>
                        <p>Tunggu beberapa menit, mungkin perlu waktu.</p>
                    </li>
                    <li>
                        <p>Periksa folder spam/sampah Anda.</p>
                    </li>
                    <li>
                        <p>Masih belum berhasil?.</p>
                    </li>
                </ul>

                {status === "verification-link-sent" && (
                    <div className="mb-4 text-sm font-medium text-green-600">
                        Tautan verifikasi baru telah dikirim ke email yang Anda
                        berikan saat pendaftaran.
                    </div>
                )}

                <form onSubmit={submit}>
                    <div className="mt-4 flex items-center justify-between">
                        <Button disabled={processing}>
                            Resend Verification Email
                        </Button>

                        <Link
                            href={route("logout")}
                            method="post"
                            as="button"
                            className="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Log Out
                        </Link>
                    </div>
                </form>
            </section>
        </GuestLayout>
    );
}
