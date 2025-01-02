import PrimaryButton from "@/Components/PrimaryButton";
import GuestLayout from "@/Layouts/GuestLayout";
import { Button } from "@/components/ui/button";
import { Head, Link, useForm } from "@inertiajs/react";
import { FormEventHandler } from "react";

export default function VerifyEmail({ status }: { status?: string }) {
    const { post, processing } = useForm({});

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route("verification.send"));
    };

    return (
        <GuestLayout>
            <Head title="Email Verification" />

            <section className="px-8 py-4 w-[calc(40vw-6rem)]">
                <h1 className="text-[3.25rem] font-medium">
                    Cek pesan di email kamu yuk!!
                </h1>
                <p>
                    klik link untuk menyelesaikan pembuatan akun anda,
                    Terimakasih!!
                </p>

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
