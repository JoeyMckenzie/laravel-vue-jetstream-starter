<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionSection from '@/Components/ActionSection.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import type { Team } from '@/types';

const props = defineProps<{
    team: Team;
}>();

const confirmingTeamDeletion = ref(false);
const form = useForm({});

function confirmTeamDeletion() {
    confirmingTeamDeletion.value = true;
}

function deleteTeam() {
    form.delete(route('teams.destroy', [props.team]), {
        errorBag: 'deleteTeam',
    });
}
</script>

<template>
    <ActionSection>
        <template #title>
            Delete Team
        </template>

        <template #description>
            Permanently delete this team.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this team, please download any data or information regarding this team that you wish to retain.
            </div>

            <div class="mt-5">
                <DangerButton type="button" @click="confirmTeamDeletion">
                    Delete Team
                </DangerButton>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <ConfirmationModal :show="confirmingTeamDeletion" @close="confirmingTeamDeletion = false">
                <template #title>
                    Delete Team
                </template>

                <template #content>
                    Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.
                </template>

                <template #footer>
                    <SecondaryButton type="button" @click="confirmingTeamDeletion = false">
                        Cancel
                    </SecondaryButton>

                    <DangerButton
                        type="submit"
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteTeam"
                    >
                        Delete Team
                    </DangerButton>
                </template>
            </ConfirmationModal>
        </template>
    </ActionSection>
</template>
