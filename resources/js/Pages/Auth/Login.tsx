import InputError from "@/components/InputError";
import GuestLayout from "@/Layouts/GuestLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import { FormEventHandler } from "react";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Button } from "@/components/ui/button";
import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { UserSchema } from "@/lib/schema/UserSchema";
import GoogleIcon from "@/assets/svgr/google";
import InputPassword from "@/components/InputPassword";
import { router } from "@inertiajs/react";

export default function Login({
    status,
    canResetPassword,
}: {
    status?: string;
    canResetPassword: boolean;
}) {
    const { data, setData, post, processing, errors, reset } = useForm<
        z.infer<typeof UserSchema.LOGIN>
    >({
        resolver: zodResolver(UserSchema.LOGIN),
        defaultValues: {
            email: "",
            password: "",
        },
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        const dataParse = UserSchema.LOGIN.safeParse(data);

        if (dataParse.success) {
            post(route("login"), {
                onFinish: () => {
                    reset();
                },
            });
        } else {
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
            <Head title="Log in" />
            <section className="px-8 py-4 w-[calc(40vw-6rem)]">
                <div className="mb-8">
                    <h1 className="text-[3.25rem] font-medium">Login</h1>
                    <p className="text-gray-500">
                        Belum Punya Akun?{" "}
                        <Link
                            href={route("register")}
                            className="rounded-md text-black underline hover:text-gray-400 focus:outline-none"
                        >
                            buat akun
                        </Link>
                    </p>
                </div>

                {status && (
                    <div className="mb-4 text-sm font-medium text-green-600">
                        {status}
                    </div>
                )}

                <form onSubmit={submit}>
                    <div>
                        <Label htmlFor="email">Email</Label>
                        <Input
                            id="email"
                            name="email"
                            value={data.email}
                            placeholder="Email"
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
                    </div>
                    <div className="mt-4 mb-8">
                        {canResetPassword && (
                            <Link
                                href={route("password.request")}
                                className="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none"
                            >
                                Lupa Password?
                            </Link>
                        )}
                    </div>
                    <Button className="w-full" disabled={processing}>
                        Login
                    </Button>
                </form>
                <div className="flex items-center my-8 ">
                    <div className="bg-gray-300 h-0.5 rounded-full flex-auto"></div>
                    <div className="mx-3 text-gray-500">atau login dengan</div>
                    <div className="bg-gray-300 h-0.5 rounded-full flex-auto"></div>
                </div>
                <a href={"oauth/google"} target="_blank">
                    <Button variant="outline" className="w-full">
                        <GoogleIcon className="w-6 h-6" />
                        Login dengan Google
                    </Button>
                </a>
            </section>
        </GuestLayout>
    );
}
