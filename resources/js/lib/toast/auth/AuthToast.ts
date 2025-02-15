import { toast } from "@/hooks/use-toast";
import { User } from "@/types/model/User";

export function loggedInToast(user: User) {
    toast({
        variant: "primary",
        title: "You are now logged in",
        description: `Welcome back, ${user.name}! You are now logged in to your account.`,
    });
}

export function registeredToast(user: User, appName: string) {
    toast({
        variant: "primary",
        title: "You already register",
        description: `Welcome to ${appName}, ${user.name}! Book your first course.`,
    });
}
