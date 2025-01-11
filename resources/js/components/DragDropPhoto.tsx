import { useState, useCallback } from "react";
import { useDragDrop } from "@/hooks/use-drag-drop";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import { CameraIcon, XMarkIcon } from "@heroicons/react/24/outline";
import InputError from "@/components/InputError";

interface DragDropPhotoProps {
    path?: string;
    errMessage?: string;
    setData: (image: File | null) => void;
}

export function DragDropPhoto({
    setData,
    path,
    errMessage,
}: DragDropPhotoProps) {
    const {
        isDragging,
        handleDragEnter,
        handleDragLeave,
        handleDragOver,
        handleDrop,
    } = useDragDrop();

    const [image, setImage] = useState<string | null>(path ?? null);

    const handleFile = useCallback((file: File) => {
        if (file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = (e) => {
                setImage(e.target?.result as string);
            };
            reader.readAsDataURL(file);
        } else {
            alert("Please upload an image file");
        }
    }, []);

    const onDrop = useCallback(
        (e: React.DragEvent<HTMLDivElement>) => {
            const file = handleDrop(e);
            if (file) {
                handleFile(file);
                setData(file);
            }
        },
        [handleDrop, handleFile]
    );

    const handleFileInput = useCallback(
        (e: React.ChangeEvent<HTMLInputElement>) => {
            const file = e.target.files?.[0];
            if (file) {
                handleFile(file);
                setData(file);
            }
        },
        [handleFile]
    );

    return (
        <div className="w-full max-h-full">
            <Label htmlFor="photo">Upload Photo</Label>
            <div
                className={`border-2 border-dashed max-h-fit rounded-lg p-2 mt-1 transition-colors ${
                    isDragging
                        ? "border-primary bg-primary/10"
                        : "border-muted-foreground"
                }`}
                onDragEnter={handleDragEnter}
                onDragLeave={handleDragLeave}
                onDragOver={handleDragOver}
                onDrop={onDrop}
            >
                {image ? (
                    <div className="relative w-full h-48">
                        <img
                            src={image}
                            alt="Uploaded"
                            className="w-full h-full object-cover rounded-md"
                        />
                        <Button
                            variant="destructive"
                            size="icon"
                            className="absolute top-2 right-2"
                            onClick={() => {
                                setImage(null);
                                setData(null);
                            }}
                            aria-label="Remove image"
                        >
                            <XMarkIcon className="h-4 w-4" />
                        </Button>
                    </div>
                ) : (
                    <div className="flex flex-col items-center justify-center py-4 relative">
                        <button
                            className="absolute z-30 inset-0 cursor-pointer"
                            onClick={(e) => {
                                e.preventDefault();
                                e.stopPropagation();
                                document.getElementById("photo")?.click();
                            }}
                        ></button>
                        <CameraIcon className="w-12 h-12 mb-4 p-3 text-primary rounded-full bg-primary-foreground" />
                        <p className="text-sm text-muted-foreground text-center mb-2">
                            <span className="font-medium text-gray-500">
                                <span className="text-primary">
                                    Upload Gambar
                                </span>{" "}
                                atau drag & drop
                            </span>
                            <br />
                            <span className="font-normal">
                                PNG, JPG, GIF hingga 10MB
                            </span>
                        </p>
                        <Input
                            id="photo"
                            type="file"
                            accept="image/*"
                            onChange={handleFileInput}
                            className="hidden"
                        />
                    </div>
                )}
            </div>
            <InputError message={errMessage} className="mt-2" />
        </div>
    );
}
