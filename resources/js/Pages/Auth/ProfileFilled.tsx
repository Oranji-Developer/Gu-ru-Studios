import GuestLayout from "@/Layouts/GuestLayout";
import { Button } from "@/components/ui/button";
import { Head, Link, useForm, usePage } from "@inertiajs/react";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { FormEventHandler } from "react";
import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { UserSchema } from "@/lib/schema/UserSchema";
import InputError from "@/components/InputError";
import { useState } from "react";

export default function Profilled({ status }: { status?: string }) {
    const page = usePage();

    const { data, setData, post, processing, errors, reset } = useForm<
        z.infer<typeof UserSchema.PROFILE>
    >({
        resolver: zodResolver(UserSchema.PROFILE),
        email: page.props.auth.user.email,
        name: page.props.auth.user.name,
        phone: "",
        address: "",
    });

    const [zodError, setZodError] = useState<string | null>(null);

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        const dataParse = UserSchema.PROFILE.safeParse(data);
        if (dataParse.success) {
            post(route("profiled.store"), {
                onFinish: () => {
                    reset();
                },
            });
        } else {
            setZodError(
                dataParse.error.errors.map((e) => e.message).join(", ")
            );
        }
    };

    return (
        <GuestLayout>
            <Head title="Profil Filled" />
            <section className="px-8 py-4 w-[calc(40vw-6rem)]">
                <div className="mb-8">
                    <h1 className="text-[3.25rem] font-medium">
                        Masukan Data diri kamu 📝
                    </h1>
                    <p>
                        Data diri kamu pasti aman kok, soalnya data kamu akan
                        kami enkripsi
                    </p>
                </div>

                {status === "profiled-failed" && (
                    <div className="mb-4 text-sm font-medium text-green-600">
                        Gagal update data diri kamu
                    </div>
                )}

                <div className="mb-4 text-sm font-medium text-red-600">
                    {zodError}
                </div>

                <form onSubmit={submit}>
                    <div className="mt-2">
                        <Label htmlFor="phone">Nomer Telepon</Label>
                        <Input
                            id="phone"
                            name="phone"
                            value={data.phone}
                            type="text"
                            inputMode="numeric"
                            placeholder="+62 812 3456 7890"
                            autoComplete="phone"
                            onChange={(e) => setData("phone", e.target.value)}
                        />

                        <InputError message={errors.phone} className="mt-2" />
                    </div>
                    <div className="mt-4 mb-8">
                        <Label htmlFor="address">Alamat</Label>
                        <Input
                            id="address"
                            name="address"
                            value={data.address}
                            type="text"
                            placeholder="Jl. Jendral Sudirman No. 1"
                            autoComplete="address"
                            onChange={(e) => setData("address", e.target.value)}
                        />

                        <InputError message={errors.address} className="mt-2" />
                    </div>

                    <Button className="w-full" disabled={processing}>
                        Submit
                    </Button>
                </form>
            </section>
        </GuestLayout>
    );
}
