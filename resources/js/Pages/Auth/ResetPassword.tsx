import InputError from "@/components/InputError";
import GuestLayout from "@/Layouts/GuestLayout";
import { Head, useForm } from "@inertiajs/react";
import { FormEventHandler } from "react";
import { Label } from "@/components/ui/label";
import { Input } from "@/components/ui/input";
import InputPassword from "@/components/InputPassword";
import { Button } from "@/components/ui/button";
import { UserSchema } from "@/lib/schema/UserSchema";
import { router } from "@inertiajs/react";
import { z } from "zod";
import { handlingZodInputError } from "@/lib/utils/handlingInputError";

export default function ResetPassword({
    token,
    email,
}: {
    token: string;
    email: string;
}) {
    const { data, setData, post, processing, errors, reset } = useForm<
        z.infer<typeof UserSchema.FORGOTPASSWORD>
    >({
        token: token,
        email: email,
        password: "",
        password_confirmation: "",
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        let dataParse = UserSchema.FORGOTPASSWORD.safeParse(data);

        if (dataParse.success) {
            post(route("password.store"), {
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
            <Head title="Reset Password" />

            <section className="px-8 py-4 w-[calc(40vw-6rem)]">
                <div className="mb-4">
                    <h1 className="text-[3.25rem] font-medium">
                        Ubah Password
                    </h1>
                    <p className="text-2xl text-gray-400 leading-7">
                        Ubah Password kamu dan coba untuk selalu ingat yaa.
                    </p>
                </div>

                <form onSubmit={submit}>
                    <div>
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
                    </div>

                    <div className="mt-4">
                        <InputPassword
                            id="password"
                            name="password"
                            onChange={(e) =>
                                setData("password", e.target.value)
                            }
                            value={data.password}
                            placeholder="Password"
                            error={errors.password}
                        />

                        <InputError
                            message={errors.password}
                            className="mt-2"
                        />
                    </div>

                    <div className="mt-4">
                        <InputPassword
                            label="Confirm Password"
                            id="password_confirmation"
                            name="password_confirmation"
                            onChange={(e) =>
                                setData("password_confirmation", e.target.value)
                            }
                            value={data.password_confirmation}
                            placeholder="Confirm password"
                            error={errors.password}
                        />

                        <InputError
                            message={errors.password_confirmation}
                            className="mt-2"
                        />
                    </div>

                    <div className="mt-4 flex items-center justify-end">
                        <Button className="w-full" disabled={processing}>
                            Reset Password
                        </Button>
                    </div>
                </form>
            </section>
        </GuestLayout>
    );
}
