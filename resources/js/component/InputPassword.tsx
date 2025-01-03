"use client";

import { useState } from "react";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Button } from "@/Components/ui/button";
import { Eye, EyeOff } from "lucide-react";
import InputError from "@/component/InputError";

export default function InputWithLabel({
    onChange,
    value,
    placeholder,
    id,
    error,
    label = "Password",
    name = "password",
}: {
    onChange: (e: React.ChangeEvent<HTMLInputElement>) => void;
    value: string;
    label?: string;
    placeholder: string;
    id: string;
    name: string;
    error?: string;
}) {
    const [showPassword, setShowPassword] = useState(false);

    return (
        <div className="">
            <Label htmlFor="password">{label}</Label>
            <div className="relative">
                <Input
                    name={name}
                    type={showPassword ? "text" : "password"}
                    id={id}
                    placeholder={placeholder}
                    className="pr-10"
                    value={value}
                    onChange={onChange}
                />
                <Button
                    type="button"
                    variant="ghost"
                    size="icon"
                    className="absolute right-0 top-0 h-full px-3 py-2 hover:bg-transparent"
                    onClick={() => setShowPassword(!showPassword)}
                    aria-label={
                        showPassword ? "Hide password" : "Show password"
                    }
                >
                    {showPassword ? (
                        <EyeOff className="h-4 w-4" />
                    ) : (
                        <Eye className="h-4 w-4" />
                    )}
                </Button>
            </div>
            <InputError message={error} className="mt-2" />
        </div>
    );
}
