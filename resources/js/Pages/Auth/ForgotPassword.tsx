import InputError from "@/components/InputError";
import PrimaryButton from "@/components/PrimaryButton";
import TextInput from "@/components/TextInput";
import { Label } from "@/components/ui/label";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import GuestLayout from "@/Layouts/GuestLayout";
import { Head, useForm } from "@inertiajs/react";
import { FormEventHandler } from "react";
import { Link } from "@inertiajs/react";
import { z } from "zod";
import { UserSchema } from "@/lib/schema/UserSchema";
import { router } from "@inertiajs/react";

export default function ForgotPassword({ status }: { status?: string }) {
    const { data, setData, post, processing, errors } = useForm<
        z.infer<typeof UserSchema.REQUESTFORGOTPASSWORD>
    >({
        email: "",
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        let dataParse = UserSchema.REQUESTFORGOTPASSWORD.safeParse(data);

        if (dataParse.success) {
            post(route("password.email"));
        } else {
            console.log(dataParse.error.issues);
            for (const issue of dataParse.error.issues) {
                if (
                    errors[issue.path[0] as keyof typeof errors] === undefined
                ) {
                    errors[issue.path[0] as keyof typeof errors] =
                        issue.message;
                } else {
                    errors[issue.path[0] as keyof typeof errors] +=
                        ", " + issue.message;
                }
            }
            router.reload();
        }
    };

    return (
        <GuestLayout>
            <Head title="Forgot Password" />
            <section className="px-8 py-4 w-[calc(40vw-6rem)]">
                <div className="mb-4">
                    <h1 className="text-[3.25rem] font-medium">
                        Lupa Password?
                    </h1>
                    <p className="text-2xl text-gray-400 leading-7">
                        Jangan khawatir, kami akan mengirimkan instruksi
                        pengaturan ulang.
                    </p>
                </div>

                {status && (
                    <div className="mb-4 text-sm font-medium text-green-600">
                        {status}
                    </div>
                )}

                <form onSubmit={submit}>
                    <Label htmlFor="email">Email</Label>
                    <Input
                        className="mt-1"
                        id="email"
                        name="email"
                        value={data.email}
                        placeholder="Masukan Email"
                        autoComplete="email"
                        onChange={(e) => setData("email", e.target.value)}
                    />

                    <InputError message={errors.email} className="mt-2" />

                    <div className="mt-4 flex flex-col gap-3 items-center">
                        <Button className="w-full" disabled={processing}>
                            Reset Password
                        </Button>
                        <Link
                            as="button"
                            href={route("login")}
                            className="w-full"
                        >
                            <Button
                                className="w-full text-gray-600"
                                variant="outline"
                            >
                                Kembali ke Login
                            </Button>
                        </Link>
                    </div>
                </form>
            </section>
        </GuestLayout>
    );
}
