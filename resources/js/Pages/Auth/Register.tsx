import InputError from "@/components/InputError";
import InputPassword from "@/components/InputPassword";
import { Label } from "@/components/ui/label";
import GuestLayout from "@/Layouts/GuestLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import { FormEventHandler } from "react";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { zodResolver } from "@hookform/resolvers/zod";
import { UserSchema } from "@/lib/schema/UserSchema";
import { z } from "zod";
import GoogleIcon from "@/assets/svgr/google";
import { router } from "@inertiajs/react";
import { handlingZodInputError } from "@/lib/utils/handlingInputError";
import { toast } from "@/hooks/use-toast";

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm<
        z.infer<typeof UserSchema.REGISTER>
    >({
        resolver: zodResolver(UserSchema.REGISTER),
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
    });

    const submit: FormEventHandler = async (e) => {
        e.preventDefault();

        let dataParse = await UserSchema.REGISTER.safeParseAsync(data);

        if (dataParse.success) {
            post(route("register"), {
                onFinish: () => reset("password", "password_confirmation"),
            });
        } else {
            handlingZodInputError(dataParse, errors);
            router.reload();
        }
    };

    return (
        <GuestLayout>
            <Head title="Register" />

            <section className="px-8 py-4 w-[calc(40vw-6rem)]">
                <div className="mb-8">
                    <h1 className="text-[3.25rem] font-medium">Buat akun</h1>
                    <p className="text-gray-500">
                        Udah Punya Akun?{" "}
                        <Link href="login" className="underline text-black">
                            Login aja
                        </Link>
                    </p>
                </div>

                <form onSubmit={submit}>
                    <div>
                        <Label htmlFor="name">Name</Label>
                        <Input
                            id="name"
                            name="name"
                            value={data.name}
                            placeholder="Name"
                            autoComplete="name"
                            onChange={(e) => setData("name", e.target.value)}
                        />

                        <InputError message={errors.name} className="mt-2" />
                    </div>
                    <div className="mt-4">
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

                    <div className="mt-4 mb-4">
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
                    </div>

                    <Button className="w-full" disabled={processing}>
                        Buat akun
                    </Button>
                    <div className="flex items-center my-8 ">
                        <div className="bg-gray-300 h-0.5 rounded-full flex-auto"></div>
                        <div className="mx-3 text-gray-500">
                            atau login dengan
                        </div>
                        <div className="bg-gray-300 h-0.5 rounded-full flex-auto"></div>
                    </div>
                    <a href={"oauth/google"} target="_blank">
                        <Button
                            variant="outline"
                            className="w-full"
                            type="button"
                        >
                            <GoogleIcon className="w-6 h-6" />
                            Login dengan Google
                        </Button>
                    </a>
                </form>
            </section>
        </GuestLayout>
    );
}
