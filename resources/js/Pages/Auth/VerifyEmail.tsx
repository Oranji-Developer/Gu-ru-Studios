import GuestLayout from "@/Layouts/GuestLayout";
import { Button } from "@/components/ui/button";
import { Head, Link, useForm, usePage } from "@inertiajs/react";
import { FormEventHandler } from "react";
import { useToast } from "@/hooks/use-toast";
import { router } from "@inertiajs/react";

export default function VerifyEmail({ status }: { status?: string }) {
    const { post, processing } = useForm({});

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route("verification.send"));
    };

    const page = usePage();
    const user = page.props.auth.user;

    const { toast } = useToast();

    router.on("start", (event) => {
        if (status === "verification-link-sent") showToast();
    });

    function showToast() {
        toast({
            title: "Verification Email Sent",
            description:
                "Tautan verifikasi baru telah dikirim ke email yang Anda berikan saat pendaftaran.",
        });
    }

    return (
        <GuestLayout>
            <Head title="Email Verification" />

            <section className="px-8 py-4 w-[calc(40vw-6rem)]">
                <h1 className="text-[3.25rem] font-medium">
                    Terima kasih telah mendaftar! 🎉
                </h1>
                <p className="font-medium mt-8">
                    Kami baru saja mengirimkan email verifikasi ke: <br />
                    <span className="text-primary">[{user.email}]</span>
                </p>

                <p className="my-6">
                    Silakan periksa kotak masuk (atau folder spam) dan klik
                    tautan untuk memverifikasi alamat email Anda. Langkah ini
                    membantu kami menjaga keamanan akun Anda.
                </p>

                <h5 className="mb-4 text-lg font-semibold">
                    💡 Tidak menerima email?
                </h5>
                <ul className="list-disc list-inside text-gray-500 font-medium mb-8">
                    <li>Tunggu beberapa menit, mungkin perlu waktu.</li>
                    <li>Periksa folder spam/sampah Anda.</li>
                    <li>Masih belum berhasil?.</li>
                </ul>

                <form onSubmit={submit} className="my-8">
                    <div className="mt-4 flex flex-col items-center justify-between gap-8">
                        <Button disabled={processing} className="w-full">
                            Resend Verification Email
                        </Button>
                        <p className="font-medium text-gray-500 leading-5">
                            Jika Anda memiliki masalah, jangan ragu untuk
                            menghubungi kami di{" "}
                            <span className="text-primary">
                                [gurustudioscrm@gmail.com].
                            </span>
                        </p>

                        <Link
                            href={route("logout")}
                            method="post"
                            as="button"
                            className="self-end rounded-md font-medium leading-5 text-gray-500 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Log Out
                        </Link>
                    </div>
                </form>
            </section>
        </GuestLayout>
    );
}
