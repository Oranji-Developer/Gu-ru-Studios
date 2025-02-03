import { AdminLayout } from "@/Layouts/AdminLayout";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import InputError from "@/components/InputError";
import { MentorSchema } from "@/lib/schema/MentorSchema";
import { Head, useForm, usePage, Link } from "@inertiajs/react";
import { zodResolver } from "@hookform/resolvers/zod";
import { set, z } from "zod";
import { Textarea } from "@/components/ui/textarea";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import { DragDropPhoto } from "@/components/DragDropPhoto";
import { Button } from "@/components/ui/button";
import { FormEventHandler } from "react";
import { handlingZodInputError } from "@/lib/utils/handlingInputError";
import { router } from "@inertiajs/react";
import { Mentor } from "@/types/Mentor";

export default function Edit() {
    const page = usePage().props;
    const mentor = page.mentor as Mentor;
    console.log(mentor);
    const { data, setData, put, processing, errors } = useForm<
        z.infer<typeof MentorSchema.UPDATE>
    >({
        resolver: zodResolver(MentorSchema.UPDATE),
        name: mentor.name ?? "",
        address: mentor.address ?? "",
        desc: mentor.desc ?? "",
        phone: mentor.phone ?? "",
        gender: mentor.gender ?? "",
        field: mentor.field ?? "",
        portfolio: mentor.portfolio ?? "",
        profile_picture: null,
        cv: null,
    });

    const fields = page.fields as string[];
    const gender = page.gender as string[];

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        const dataParse = MentorSchema.UPDATE.safeParse(data);

        console.log(dataParse);

        if (dataParse.success) {
            router.post(route("admin.mentor.update", { mentor: mentor.id }), {
                _method: "put",
                name: dataParse.data.name,
                address: dataParse.data.address,
                desc: dataParse.data.desc,
                phone: dataParse.data.phone,
                gender: dataParse.data.gender,
                field: dataParse.data.field,
                profile_picture: dataParse.data.profile_picture,
                cv: dataParse.data.cv,
                portfolio: dataParse.data.portfolio,
                youtube: dataParse.data.youtube,
            });
        } else {
            handlingZodInputError(dataParse, errors);
            router.reload();
        }
    };
    return (
        <AdminLayout
            header={
                <div>
                    <h1 className="text-2xl font-semibold leading-[1.8rem]">
                        Ubah Mentor
                    </h1>
                    <p className="text-sm leading-[1.05rem] text-gray-400">
                        Ubah informasi mentor.
                    </p>
                </div>
            }
        >
            <Head title="Modifikasi Mentor" />
            <section>
                <form
                    onSubmit={submit}
                    className="grid grid-cols-1 gap-4 md:grid-cols-2"
                >
                    <div className="flex flex-col gap-4">
                        <div>
                            <Label htmlFor="name">Nama</Label>
                            <Input
                                id="name"
                                name="name"
                                value={data.name}
                                placeholder="Masukkan Nama Mentor"
                                autoComplete="name"
                                onChange={(e) =>
                                    setData("name", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.name}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <Label htmlFor="phone">Nomor Telepon</Label>
                            <Input
                                id="phone"
                                name="phone"
                                value={data.phone}
                                placeholder="Masukkan Nomor Telepon Mentor"
                                autoComplete="phone"
                                onChange={(e) =>
                                    setData("phone", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.phone}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <Label htmlFor="address">Alamat</Label>
                            <Input
                                id="address"
                                name="address"
                                value={data.address}
                                placeholder="Masukkan Alamat Mentor"
                                autoComplete="address"
                                onChange={(e) =>
                                    setData("address", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.address}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <Label htmlFor="desc">Deskripsi</Label>
                            <Textarea
                                id="desc"
                                name="desc"
                                value={data.desc}
                                placeholder="Masukkan Deskripsi Mentor"
                                autoComplete="desc"
                                onChange={(e) =>
                                    setData("desc", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.desc}
                                className="mt-2"
                            />
                        </div>

                        <div className="w-full">
                            <Label>Gender</Label>
                            <RadioGroup
                                value={data.gender}
                                defaultValue="male"
                                className="flex w-full gap-5"
                            >
                                {gender.map((element) => (
                                    <div
                                        key={element}
                                        className={`rounded-full focus:border-primary flex items-center space-x-2 w-full border border-input bg-background shadow-sm hover:bg-accent hover:text-accent-foreground px-5 py-3 ${
                                            data.gender === element
                                                ? "border-primary text-primary bg-primary-foreground"
                                                : ""
                                        }`}
                                    >
                                        <RadioGroupItem
                                            onClick={() =>
                                                setData("gender", element)
                                            }
                                            value={element}
                                            id={element}
                                        />
                                        <Label htmlFor={element}>
                                            {element.charAt(0).toUpperCase() +
                                                element.slice(1)}
                                        </Label>
                                    </div>
                                ))}
                            </RadioGroup>
                        </div>

                        <div>
                            <Label>Tipe Kelas</Label>
                            <RadioGroup
                                value={data.field}
                                defaultValue="male"
                                className="flex w-full gap-5"
                            >
                                {fields.map((element) => (
                                    <div
                                        key={element}
                                        className={`rounded-full focus:border-primary flex items-center space-x-2 w-full border border-input bg-background shadow-sm hover:bg-accent hover:text-accent-foreground px-5 py-3 ${
                                            data.field === element
                                                ? "border-primary text-primary bg-primary-foreground"
                                                : ""
                                        }`}
                                    >
                                        <RadioGroupItem
                                            onClick={() =>
                                                setData("field", element)
                                            }
                                            value={element}
                                            id={element}
                                        />
                                        <Label htmlFor={element}>
                                            {element.charAt(0).toUpperCase() +
                                                element.slice(1)}
                                        </Label>
                                    </div>
                                ))}
                            </RadioGroup>
                        </div>
                    </div>
                    <div className="flex flex-col gap-4">
                        {mentor.profile_picture ? (
                            <DragDropPhoto
                                path={"/storage/" + mentor.profile_picture}
                                setData={(e) => {
                                    setData("profile_picture", e);
                                }}
                                errMessage={errors.profile_picture}
                            />
                        ) : (
                            <DragDropPhoto
                                setData={(e) => {
                                    setData("profile_picture", e);
                                }}
                                errMessage={errors.profile_picture}
                            />
                        )}

                        <div>
                            <Label htmlFor="cv">Upload CV</Label>
                            <Input
                                id="cv"
                                name="cv"
                                type="file"
                                accept="application/pdf"
                                placeholder="Masukkan CV Mentor"
                                autoComplete="cv"
                                onChange={(e) =>
                                    setData("cv", e.target.files?.[0])
                                }
                            />

                            <InputError message={errors.cv} className="mt-2" />
                            {mentor.cv && (
                                <div className="preview mt-2">
                                    <a
                                        href={"/storage/" + mentor.cv}
                                        target="_blank"
                                    >
                                        <Button
                                            type="button"
                                            variant="secondary"
                                        >
                                            {mentor.cv.split("/").pop()}
                                        </Button>
                                    </a>
                                </div>
                            )}
                        </div>

                        <div>
                            <Label htmlFor="portfolio">
                                Link Youtube Portofolio
                            </Label>
                            <Input
                                id="portfolio"
                                name="portfolio"
                                value={data.portfolio}
                                placeholder="Tambahkan Link Youtube Mentor"
                                autoComplete="portfolio"
                                onChange={(e) =>
                                    setData("portfolio", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.portfolio}
                                className="mt-2"
                            />
                        </div>

                        <div className="flex justify-end gap-4">
                            <Button
                                type="button"
                                variant="outline"
                                onClick={() =>
                                    router.visit(route("admin.mentor.index"))
                                }
                            >
                                Batal Menambahkan Mentor
                            </Button>
                            <Button disabled={processing}>Simpan Mentor</Button>
                        </div>
                    </div>
                </form>
            </section>
        </AdminLayout>
    );
}
