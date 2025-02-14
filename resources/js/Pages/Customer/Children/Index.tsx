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
import { useForm, usePage } from "@inertiajs/react";
import { ChildrenSchema } from "@/lib/schema/ChildrenSchema";
import { Input } from "@/components/ui/input";
import InputError from "@/components/InputError";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { z, ZodError } from "zod";

export default function Index() {
    const page = usePage().props;

    const gender = page.gender as string[];

    const classType = page.classes as string[];

    const { data, setData, post, processing, errors, reset } = useForm<
        z.infer<typeof ChildrenSchema.CREATE>
    >({
        name: "",
        gender: "",
        class: "",
    });

    return (
        <div>
            <Dialog>
                <DialogTrigger asChild>
                    <Button>Daftar Kelas</Button>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Tambahkan Anak Anda</DialogTitle>
                        <DialogDescription>
                            Lengkapi form di bawah ini untuk menambahkan anak
                            Anda.
                        </DialogDescription>
                    </DialogHeader>
                    <form>
                        <section>
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
                                                    setData("gender", element)
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
                                    onValueChange={(e) => setData("class", e)}
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
                        <Button type="submit" className="w-full">
                            Save changes
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    );
}
