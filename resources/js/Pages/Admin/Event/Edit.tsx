import { AdminLayout } from "@/Layouts/AdminLayout";
import { Head, router } from "@inertiajs/react";
import React from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import InputError from "@/components/InputError";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/components/ui/popover";
import { Calendar } from "@/components/ui/calendar";
import { CalendarIcon } from "@heroicons/react/24/solid";
import { DragDropPhoto } from "@/components/DragDropPhoto";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { usePage, useForm } from "@inertiajs/react";
import { EventSchema } from "@/lib/schema/EventSchema";
import { z } from "zod";
import { cn } from "@/lib/utils";
import { useState } from "react";
import { DateRange } from "react-day-picker";
import { addDays, format } from "date-fns";
import { Event } from "@/types/Event";
import { handlingZodInputError } from "@/lib/utils/handlingInputError";
import { FormEventHandler } from "react";

export default function Edit() {
    const page = usePage().props;
    const dataFetch = page.event as Event;
    const course_type = page.course_types as string[];
    const academic_class = page.academic_class as string[];
    const art_class = page.arts_class as string[];
    const status = page.status as string[];

    function handleClassType(element: string) {
        if (element === "akademik") {
            return academic_class;
        } else if (element === "seni") {
            return art_class;
        } else {
            return [];
        }
    }

    const [classType, setClassType] = useState<string[]>(
        handleClassType(dataFetch.course_type)
    );

    const { data, setData, post, processing, errors } = useForm<
        z.infer<typeof EventSchema.UPDATE>
    >({
        _method: "put",
        title: dataFetch.title,
        desc: dataFetch.desc,
        left_text: "",
        right_text: "",
        thumbnail: null,
        path: "/storage/" + dataFetch.thumbnail,
        disc: dataFetch.disc,
        course_type: dataFetch.course_type,
        class: dataFetch.class,
        status: dataFetch.status,
    });

    console.log(page);
    console.log(data);

    const [date, setDate] = useState<DateRange | undefined>({
        from: new Date(dataFetch.start_date),
        to: new Date(dataFetch.end_date),
    });

    function handleDateChange() {
        setData("start_date", date?.from);
        setData("end_date", date?.to);
    }

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        const dataParse = EventSchema.UPDATE.safeParse(data);

        if (dataParse.success) {
            post(route("admin.event.update", { course: dataFetch.id }), {
                forceFormData: true,
            });
        } else {
            handlingZodInputError(dataParse, errors);
            router.reload();
        }
    };

    return (
        <AdminLayout
            header={
                <div className="flex justify-between items-center">
                    <div>
                        <h1 className="text-2xl font-semibold leading-[1.8rem]">
                            Edit Event
                        </h1>
                        <p className="text-sm leading-[1.05rem] text-gray-400">
                            Edit event information or change status
                        </p>
                    </div>
                </div>
            }
        >
            <Head title="Edit Event" />
            <form onSubmit={submit} className="pb-10 border-t">
                <section className="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2">
                    <div className="flex flex-col gap-2">
                        <div>
                            <Label htmlFor="title">Nama Kelas</Label>
                            <Input
                                id="title"
                                title="title"
                                value={data.title}
                                placeholder="Masukkan Nama Kelas"
                                autoComplete="title"
                                onChange={(e) =>
                                    setData("title", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.title}
                                className="mt-2"
                            />
                        </div>
                        <div>
                            <Label htmlFor="title">Deskripsi Event</Label>
                            <Input
                                id="desc"
                                title="desc"
                                value={data.desc}
                                placeholder="Masukkan Deskripsi Event"
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
                        <div>
                            <Label htmlFor="date">
                                Tanggal Mulai - Tanggal Berakhir
                            </Label>
                            <Popover>
                                <PopoverTrigger asChild>
                                    <Button
                                        id="date"
                                        variant={"outline"}
                                        className={cn(
                                            "w-full justify-start text-left font-normal",
                                            !date && "text-muted-foreground"
                                        )}
                                    >
                                        <CalendarIcon />
                                        {date?.from ? (
                                            date.to ? (
                                                <>
                                                    {format(
                                                        date.from,
                                                        "LLL dd, y"
                                                    )}{" "}
                                                    -{" "}
                                                    {format(
                                                        date.to,
                                                        "LLL dd, y"
                                                    )}
                                                </>
                                            ) : (
                                                format(date.from, "LLL dd, y")
                                            )
                                        ) : (
                                            <span>Pick a date</span>
                                        )}
                                    </Button>
                                </PopoverTrigger>
                                <PopoverContent
                                    className="w-auto p-0"
                                    align="start"
                                >
                                    <Calendar
                                        initialFocus
                                        mode="range"
                                        defaultMonth={date?.from}
                                        selected={date}
                                        onSelect={setDate}
                                        numberOfMonths={2}
                                    />
                                </PopoverContent>
                            </Popover>
                            <InputError
                                message={errors.start_date || errors.end_date}
                                className="mt-2"
                            />
                        </div>
                        <div className="">
                            <DragDropPhoto
                                path={data.path}
                                errMessage={errors.thumbnail}
                                setData={(e) => {
                                    setData("thumbnail", e);
                                }}
                            />
                        </div>
                    </div>
                    <div className="flex flex-col gap-2">
                        <div>
                            <Label htmlFor="left_text">Tulisan Kiri</Label>
                            <Input
                                id="left_text"
                                title="left_text"
                                value={data.left_text}
                                placeholder="Masukkan Tulisan Kiri Event"
                                autoComplete="left_text"
                                onChange={(e) =>
                                    setData("left_text", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.left_text}
                                className="mt-2"
                            />
                        </div>
                        <div>
                            <Label htmlFor="right_text">Tulisan Kanan</Label>
                            <Input
                                id="right_text"
                                title="right_text"
                                value={data.right_text}
                                placeholder="Masukkan Tulisan Kanan Event"
                                autoComplete="right_text"
                                onChange={(e) =>
                                    setData("right_text", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.right_text}
                                className="mt-2"
                            />
                        </div>
                        <div>
                            <Label>Tipe Kelas</Label>
                            <RadioGroup
                                value={data.course_type}
                                defaultValue="male"
                                className="flex w-full gap-5"
                            >
                                {course_type.map((element) => (
                                    <Label
                                        htmlFor={element}
                                        key={element}
                                        className={`rounded-full focus:border-primary flex items-center space-x-2 w-full border border-input bg-background shadow-sm hover:bg-accent hover:text-accent-foreground px-5 py-3 ${
                                            data.course_type === element
                                                ? "border-primary text-primary bg-primary-foreground"
                                                : ""
                                        }`}
                                    >
                                        <RadioGroupItem
                                            onClick={() => {
                                                setData("course_type", element);
                                                if (element === "akademik") {
                                                    setClassType([
                                                        ...academic_class,
                                                    ]);
                                                } else if (element === "seni") {
                                                    setClassType([
                                                        ...art_class,
                                                    ]);
                                                } else {
                                                    setClassType([]);
                                                }
                                            }}
                                            value={element}
                                            id={element}
                                        />
                                        <Label htmlFor={element}>
                                            {element.charAt(0).toUpperCase() +
                                                element.slice(1)}
                                        </Label>
                                    </Label>
                                ))}
                            </RadioGroup>

                            <InputError
                                message={errors.course_type}
                                className="mt-2"
                            />
                        </div>

                        {classType.length > 0 && (
                            <div>
                                <Label>Jenis Kelas</Label>
                                <Select
                                    value={data.class}
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
                        )}

                        <div className="w-full">
                            <Label>Status</Label>
                            <RadioGroup
                                value={data.status}
                                defaultValue="male"
                                className="flex w-full gap-5"
                            >
                                {status.map((element) => (
                                    <Label
                                        htmlFor={element}
                                        key={element}
                                        className={`rounded-full focus:border-primary flex items-center space-x-2 w-full border border-input bg-background shadow-sm hover:bg-accent hover:text-accent-foreground px-5 py-3 ${
                                            data.status === element
                                                ? "border-primary text-primary bg-primary-foreground"
                                                : ""
                                        }`}
                                    >
                                        <RadioGroupItem
                                            onClick={() =>
                                                setData("status", element)
                                            }
                                            value={element}
                                            id={element}
                                        />
                                        <Label htmlFor={element}>
                                            {element.charAt(0).toUpperCase() +
                                                element.slice(1)}
                                        </Label>
                                    </Label>
                                ))}
                            </RadioGroup>

                            <InputError
                                message={errors.status}
                                className="mt-2"
                            />
                        </div>
                    </div>
                </section>
                <div className="mt-4 flex justify-end gap-4">
                    <Button
                        type="button"
                        variant="outline"
                        onClick={() => router.visit(route("admin.event.index"))}
                    >
                        Batal Menambahkan Kelas
                    </Button>
                    <Button disabled={processing} onClick={handleDateChange}>
                        Simpan Kelas
                    </Button>
                </div>
            </form>
        </AdminLayout>
    );
}
