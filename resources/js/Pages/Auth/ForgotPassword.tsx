import InputError from "@/components/InputError";
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
import { handlingZodInputError } from "@/lib/utils/handlingInputError";
import { useToast } from "@/hooks/use-toast";
import { passwordResetRequestToast } from "@/lib/toast/auth/ResetPasswordToast";

export default function ForgotPassword({ status }: { status?: string }) {
    const { data, setData, post, processing, errors, reset } = useForm<
        z.infer<typeof UserSchema.REQUESTFORGOTPASSWORD>
    >({
        email: "",
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        let dataParse = UserSchema.REQUESTFORGOTPASSWORD.safeParse(data);

        if (dataParse.success) {
            post(route("password.email"), {
                onSuccess: (event) => {
                    const status = event.props.session.flash.success;
                    if (status === "password-reset-link-sent")
                        passwordResetRequestToast();
                },
                onFinish: () => {
                    reset();
                },
            });
        } else {
            handlingZodInputError(dataParse, errors);
            router.reload();
        }
    };

    return (
        <GuestLayout>
            <Head title="Forgot Password" />
            <section className="py-4 md:px-8 w-full md:w-[calc(40vw-6rem)] flex flex-col justify-center h-screen md:block md:h-auto">
                <div className="mb-4">
                    <h1 className="text-4xl leading-normal md:text-[3.25rem] font-medium">
                        Lupa Password?
                    </h1>
                    <p className="md:text-2xl text-gray-400 leading-7">
                        Jangan khawatir, kami akan mengirimkan instruksi
                        pengaturan ulang.
                    </p>
                </div>

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
                        <Link href={route("login")} className="w-full">
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
