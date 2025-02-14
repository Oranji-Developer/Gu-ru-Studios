"use strict";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
    DialogFooter,
    DialogClose,
} from "@/components/ui/dialog";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import { useState } from "react";
import { useForm, usePage, router } from "@inertiajs/react";
import { ChildrenSchema } from "@/lib/schema/ChildrenSchema";
import { Input } from "@/components/ui/input";
import InputError from "@/components/InputError";
import { PlusIcon } from "@heroicons/react/20/solid";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { FormEventHandler } from "react";

import { z, ZodError } from "zod";
import { Children } from "@/types/Children";
import { Course } from "@/types/Course";

interface ModalChildren {}

export function ModalChildren({}: ModalChildren) {
    const page = usePage().props;

    const gender = page.gender as string[];

    const courseId = page.course as Course;

    const classType = page.classes as string[];

    const children = page.children as Children[];

    const [isAddChild, setIsAddChild] = useState(false);

    const { data, setData, post, processing, errors, reset } = useForm<
        z.infer<typeof ChildrenSchema.CREATE>
    >({
        name: "",
        gender: "",
        class: "",
        course_id: courseId.id,
    });

    const submit: FormEventHandler = async (e) => {
        e.preventDefault();
        if (data.name != "" && data.gender != "" && data.class != "") {
            post(route("user.children.store"));
        } else if (data.children_id != undefined) {
            router.visit(
                route("user.invoice", {
                    course_id: courseId.id,
                    children_id: data.children_id,
                })
            );
        }
    };

    return (
        <div>
            <Dialog>
                <DialogTrigger asChild>
                    <Button>Daftar Kelas</Button>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Apply Kelas Ini</DialogTitle>
                        <DialogDescription>
                            Pilih anak atau tambah anak Anda untuk mendaftar
                        </DialogDescription>
                    </DialogHeader>
                    <div>
                        <Select
                            onValueChange={(e) =>
                                setData("children_id", parseInt(e))
                            }
                        >
                            <SelectTrigger className="">
                                <SelectValue placeholder="Anak anda" />
                            </SelectTrigger>
                            <SelectContent>
                                {children.map((element) => (
                                    <SelectItem
                                        value={element.id.toString()}
                                        key={element.id}
                                    >
                                        {element.name}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                    </div>
                    <div className="flex justify-between items-center">
                        <div>
                            <h1 className="font-medium text-lg">
                                Tambahkan Anak Anda
                            </h1>
                            {isAddChild && (
                                <p className="text-sm text-gray-500">
                                    Lengkapi form di bawah ini untuk menambahkan
                                    anak Anda.
                                </p>
                            )}
                        </div>
                        <Button
                            variant={"outline"}
                            className="rounded-full"
                            onClick={() => setIsAddChild(!isAddChild)}
                        >
                            <PlusIcon width={24} />
                        </Button>
                    </div>
                    {isAddChild && (
                        <form onSubmit={submit}>
                            <section className="mb-6">
                                <div>
                                    <Label htmlFor="name">Nama</Label>
                                    <Input
                                        id="name"
                                        name="name"
                                        value={data.name}
                                        placeholder="Masukkan Nama Anak"
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
                                                        setData(
                                                            "gender",
                                                            element
                                                        )
                                                    }
                                                    value={element}
                                                    id={element}
                                                />
                                                <Label htmlFor={element}>
                                                    {element
                                                        .charAt(0)
                                                        .toUpperCase() +
                                                        element.slice(1)}
                                                </Label>
                                            </div>
                                        ))}
                                    </RadioGroup>
                                </div>

                                <div>
                                    <Label>Jenis Kelas</Label>
                                    <Select
                                        onValueChange={(e) =>
                                            setData("class", e)
                                        }
                                    >
                                        <SelectTrigger className="">
                                            <SelectValue placeholder="Jenis Kelas" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            {classType.map((element) => (
                                                <SelectItem
                                                    value={element}
                                                    key={element}
                                                >
                                                    {element}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>

                                    <InputError
                                        message={errors.class}
                                        className="mt-2"
                                    />
                                </div>
                            </section>
                        </form>
                    )}
                    <DialogFooter>
                        <DialogClose asChild>
                            <Button
                                type="button"
                                variant="secondary"
                                className="w-full"
                            >
                                Close
                            </Button>
                        </DialogClose>
                        <Button
                            onClick={submit}
                            disabled={processing}
                            className="w-full"
                        >
                            {isAddChild ? "Tambahkan Anak" : "Daftar Kelas"}
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    );
}
